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
        // First convert existing data to lowercase or new values
        DB::table('registrations')->where('status', 'Berhasil')->update(['status' => 'selesai']);
        DB::table('registrations')->where('status', 'Menunggu')->update(['status' => 'menunggu']);
        
        // Then change column type
        DB::statement("ALTER TABLE registrations MODIFY COLUMN status ENUM('menunggu', 'gagal', 'selesai') DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE registrations MODIFY COLUMN status VARCHAR(255)");
    }
};
