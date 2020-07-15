<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id');
            $table->foreignId('day_id');
            $table->time('start_at');
            $table->time('end_at');
            $table->unsignedTinyInteger('capacity');
            $table->boolean('new_member_session')->default(false);
            $table->unsignedTinyInteger('advance_weeks_to_create')->default(3);
            $table->timestamps();

            $table->unique(['group_id', 'day_id', 'start_at', 'end_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
