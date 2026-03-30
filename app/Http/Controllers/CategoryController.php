<?php
    
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Event::select('kategori')->distinct()->get();
        return view('category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        Event::create([
            'nama_event' => 'dummy',
            'kategori' => $request->kategori
        ]);

        return back();
    }

    public function update(Request $request, $kategori)
    {
        Event::where('kategori', $kategori)
            ->update(['kategori' => $request->kategori]);

        return back();
    }

    public function delete($kategori)
    {
        Event::where('kategori', $kategori)->delete();
        return back();
    }
}