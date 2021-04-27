<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeaturedImageToPantries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pantries', function (Blueprint $table) {
            $table->longText('featured_image_local')->nullable();
            $table->longText('featured_image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pantries', function (Blueprint $table) {
            $table->dropColumn('featured_image_local');
            $table->dropColumn('featured_image_url');
        });
    }
}
