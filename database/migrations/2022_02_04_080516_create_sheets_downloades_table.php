<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSheetsDownloadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheets_downloades', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ip');
            $table->dateTime('download_time');
            $table->integer('download_count');

            $table->index('ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sheets_downloades');
    }
}
