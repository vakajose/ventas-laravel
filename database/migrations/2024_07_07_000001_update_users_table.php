<?php
// database/migrations/xxxx_xx_xx_update_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Paso 1: Agregar la columna `role` permitiendo valores nulos inicialmente
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['cliente', 'administrador'])->nullable()->after('profile_photo_path');
        });

        // Paso 2: Asignar un valor por defecto a la columna `role` para los registros existentes
        DB::table('users')->update(['role' => 'administrador']);
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
