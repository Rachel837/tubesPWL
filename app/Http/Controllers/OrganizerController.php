<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrganizerController extends Controller
{
    public function dashboard()
    {
        // General welcome overview, or maybe just pass same complete data as dashboard overview.
        return view('organizer.dashboard');
    }

    public function statistics()
    {
        $totalSales = Registration::whereIn('status', ['Berhasil', 'Digunakan'])->count();
        return view('organizer.statistics', compact('totalSales'));
    }

    public function graph()
    {
        $chartData = Registration::whereIn('status', ['Berhasil', 'Digunakan'])
                ->selectRaw('DATE(created_at) as date, count(*) as total')
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->take(7)
                ->get();
                
        $labels = empty($chartData) ? [] : $chartData->pluck('date')->map(function($date) { return Carbon::parse($date)->format('d M'); })->toArray();
        $data = empty($chartData) ? [] : $chartData->pluck('total')->toArray();

        // Default empty data if no transactions
        if (empty($labels)) {
            $labels = [Carbon::now()->format('d M')];
            $data = [0];
        }

        return view('organizer.graph', compact('labels', 'data'));
    }

    public function revenue()
    {
        $totalRevenue = Registration::whereIn('status', ['Berhasil', 'Digunakan'])
            ->join('tiket', 'registrations.tiket_idtiket', '=', 'tiket.idtiket')
            ->sum('tiket.harga');
            
        return view('organizer.revenue', compact('totalRevenue'));
    }

    public function performance()
    {
        $events = Event::with(['eventDetails.tikets.registrations'])->get()->map(function($e) {
            $totalTiket = $e->eventDetails->sum(function($ed) {
                return $ed->tikets->sum('kuota') + $ed->tikets->sum(function($t) { return $t->registrations->count(); });
            });
            $terjual = $e->eventDetails->sum(function($ed) { 
                return $ed->tikets->sum(function($t) { return $t->registrations->count(); }); 
            });
            $e->performance = $totalTiket > 0 ? round(($terjual / $totalTiket) * 100) : 0;
            $e->terjual = $terjual;
            return $e;
        });

        return view('organizer.performance', compact('events'));
    }
    
    public function export()
    {
        $fileName = 'laporan_penjualan_'.date('YmdHis').'.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $events = Event::with(['eventDetails.tikets.registrations'])->get();

        $callback = function() use($events) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array('ID Event', 'Nama Event', 'Tanggal', 'Total Tiket Terjual', 'Pendapatan (Rp)', 'Performa (%)'));

            foreach ($events as $e) {
                $totalTiket = $e->eventDetails->sum(function($ed) {
                    return $ed->tikets->sum('kuota') + $ed->tikets->sum(function($t) { return $t->registrations->count(); });
                });
                $terjual = $e->eventDetails->sum(function($ed) { 
                    return $ed->tikets->sum(function($t) { return $t->registrations->count(); }); 
                });
                $pendapatan = $e->eventDetails->sum(function($ed) { 
                    return $ed->tikets->sum(function($t) { 
                        return $t->registrations->whereIn('status', ['Berhasil', 'Digunakan'])->count() * $t->harga; 
                    }); 
                });
                
                $perf = $totalTiket > 0 ? round(($terjual / $totalTiket) * 100) : 0;
                
                fputcsv($file, array($e->idevent, $e->nama_event, $e->date_start, $terjual, $pendapatan, $perf));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
