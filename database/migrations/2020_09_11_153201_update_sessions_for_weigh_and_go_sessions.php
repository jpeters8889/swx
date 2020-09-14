<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSessionsForWeighAndGoSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->boolean('has_seats')->default(true)->after('end_at');
            $table->boolean('has_weigh_and_go')->default(false)->after('end_at');
            $table->unsignedInteger('weigh_and_go_slots')->default(0)->after('capacity');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->renameColumn('capacity', 'seats');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn('new_member_session');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sessions', function (Blueprint $table) {
            //
        });
    }
}
