<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToPantriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pantries', function (Blueprint $table) {
            $table->foreignId('contributor_id');
            $table->foreignId('verifier_id')->nullable();
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
            $table->dropColumn('contributor_id');
            $table->dropColumn('verifier_id');
        });
    }
}
