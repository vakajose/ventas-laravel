<?php

// database/migrations/xxxx_xx_xx_create_reservations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamp('reservation_date');
            $table->timestamps();
        });

        Schema::create('reservation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('reserved_quantity');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservation_details');
        Schema::dropIfExists('reservations');
    }
};
