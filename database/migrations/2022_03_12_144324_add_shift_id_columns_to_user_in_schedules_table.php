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
        Schema::table('user__in__schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('shift_id')->after('schedule_id');
            $table->foreign('shift_id')->references('id')->on('shifts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user__in__schedules', function (Blueprint $table) {
            $table->dropForeign('user_in_schedules_shift_id_foreign');
            $table->dropColumn('shift_id');
        });
    }
};
