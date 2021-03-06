<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetIndexesAndForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('link_id')->references('id')->on('original_links');
        });

        Schema::table('archive', function (Blueprint $table) {
            $table->foreignId('former_sale_id')->references('id')->on('sales');
            $table->foreignId('link_id')->references('id')->on('original_links');

            $table->index('former_sale_id');
        });

        Schema::table('cutted_links', function (Blueprint $table) {
            $table->foreignId('lot_id')->references('id')->on('sales');
            $table->foreignId('user_token_id')->references('id')->on('linkcutter_tokens');

            $table->index('lot_id');
        });

        Schema::table('sheets_downloades', function (Blueprint $table) {
            $table->foreignId('user_token_id')->references('id')->on('linkcutter_tokens')->nullable();
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
