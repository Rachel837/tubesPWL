<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('idrole')->nullable()->after('email');
            
            // Opsional: Jika Anda ingin menambahkan foreign key (pastikan tipe data persis sama dengan idrole di tabel role)
            // $table->foreign('idrole')->references('idrole')->on('role')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->dropForeign(['idrole']);
            $table->dropColumn('idrole');
        });
    }
};
