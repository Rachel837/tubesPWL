<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add kategori_id
        Schema::table('event', function (Blueprint $table) {
            $table->unsignedBigInteger('kategori_id')->nullable()->after('kategori');
            $table->foreign('kategori_id')->references('id')->on('categories')->onDelete('set null');
        });

        // 2. Map existing data
        $events = DB::table('event')->whereNotNull('kategori')->get();
        foreach ($events as $event) {
            $catName = trim($event->kategori);
            if (!empty($catName)) {
                $category = DB::table('categories')->where('nama_kategori', $catName)->first();
                if (!$category) {
                    $catId = DB::table('categories')->insertGetId([
                        'nama_kategori' => $catName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $catId = $category->id;
                }
                DB::table('event')->where('idevent', $event->idevent)->update(['kategori_id' => $catId]);
            }
        }

        // 3. Drop old kategori column safely
        Schema::table('event', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
