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
        Schema::create('planogram_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->unsignedBigInteger('planogram_id');
            $table->timestamps();
            $table->foreign('planogram_id')->references('id')->on('planograms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planogram_files', function (Blueprint $table) {
            $table->dropForeign('planogram_files_planogram_id_foreign');
        });
        Schema::dropIfExists('planogram_files');
    }
};
