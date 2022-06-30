<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('sensor', function (Blueprint $table) {
      $table->uuid('id')->primaryKey();
      $table->integer('sensor_id');
      $table->string('label');
      $table->string('status')->default(0);      
      $table->index('sensor_id');
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
    Schema::dropIfExists('sensor');
  }
};
