<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiatInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiat_infos', function (Blueprint $table) {
            $table->id();
            $table->char('currency', 20)->unique();
            $table->unsignedTinyInteger('decimals')->default(0);
            $table->string('name', config("services.default_max_length_string"))->nullable();
            $table->string('description', config("services.default_max_length_string"))->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fiat_infos');
    }
}
