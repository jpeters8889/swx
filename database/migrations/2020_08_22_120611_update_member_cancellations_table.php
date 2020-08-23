<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMemberCancellationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_cancellations', function (Blueprint $table) {
            \App\Models\MemberCancellation::query()->truncate();

            $table->dropColumn('email');
        });

        Schema::table('member_cancellations', function (Blueprint $table) {
            $table->unsignedInteger('member_id')->after('id');

//            $table->foreign('member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_cancellations', function (Blueprint $table) {
            //
        });
    }
}
