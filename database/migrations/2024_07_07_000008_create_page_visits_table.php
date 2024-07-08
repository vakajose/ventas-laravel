<?php
// database/migrations/xxxx_xx_xx_create_page_visits_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('page_name');
            $table->timestamp('visit_date');
            $table->integer('visit_count');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_visits');
    }
};

