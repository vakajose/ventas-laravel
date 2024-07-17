<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Crear una nueva columna con el tipo enum
            $table->string('new_payment_method')->nullable();

            // Eliminar la columna antigua
            $table->dropColumn('payment_method');

            // Renombrar la nueva columna a payment_method
            $table->renameColumn('new_payment_method', 'payment_method');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Crear una nueva columna con el tipo enum antiguo
            $table->enum('old_payment_method', ['credit_card', 'cash', 'bank_transfer'])->nullable(false);

            // Eliminar la columna nueva
            $table->dropColumn('payment_method');

            // Renombrar la columna antigua a payment_method
            $table->renameColumn('old_payment_method', 'payment_method');
        });
    }
};
