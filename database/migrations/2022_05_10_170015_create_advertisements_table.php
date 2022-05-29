<?php

use App\Enums\Priority;
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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->date('start');
            $table->date('end')->nullable();
            $table->boolean('public')->default(1);
            $table->enum('priority', Priority::TYPES)->default(Priority::LOW);
            $table->unsignedBigInteger('author_id');
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropForeign('advertisements_author_id_foreign');
        });
        Schema::dropIfExists('advertisements');
    }
};
