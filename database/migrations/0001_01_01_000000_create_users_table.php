<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key otomatis "id"
            $table->string('username')->unique(); // Username unik
            $table->string('password'); // Password (akan di-hash)
            $table->enum('role', ['Frontliner', 'Kepala Cabang']); // Role user
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users'); // Hapus tabel jika rollback
    }
};