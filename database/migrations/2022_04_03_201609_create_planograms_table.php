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
        Schema::create('planograms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('current')->default(FALSE);
            $table->date('date_start');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planograms', function (Blueprint $table) {
            $table->dropForeign('planograms_user_id_foreign');
        });
        Schema::dropIfExists('planograms');
    }
};
