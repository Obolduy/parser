<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('original_link_id')->references('id')->on('original_links');
            $table->foreignId('cutted_link_id')->references('id')->on('cutted_links');
        });

        Schema::table('archive', function (Blueprint $table) {
            $table->foreignId('former_sale_id')->references('id')->on('sales');
            $table->foreignId('original_link_id')->references('id')->on('original_links');
            $table->foreignId('cutted_link_id')->references('id')->on('cutted_links');

            $table->index('former_sale_id');
        });
        
        Schema::table('original_links', function (Blueprint $table) {
            $table->foreignId('lot_id')->references('id')->on('sales');

            $table->index('lot_id');
        });

        Schema::table('cutted_links', function (Blueprint $table) {
            $table->foreignId('lot_id')->references('id')->on('sales');

            $table->index('lot_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
