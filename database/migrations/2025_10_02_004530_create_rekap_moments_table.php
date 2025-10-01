<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekap_moment', function (Blueprint $table) {
            $table->id();
            $table->string('nm_nasabah');
            $table->bigInteger('cif')->unique();
            $table->date('tgl_lahir');
            $table->string('no_hp');
            $table->enum('moments', ['Empowered Care Moment', 'Special Day Moment']);
            $table->text('deskripsi')->nullable();
            $table->string('foto_moment')->nullable();
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_moment');
    }
};