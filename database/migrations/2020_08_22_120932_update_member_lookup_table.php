<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMemberLookupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_lookups', function (Blueprint $table) {
            \App\Models\MemberLookup::query()->truncate();

            $table->dropColumn('email');
        });

        Schema::table('member_lookups', function (Blueprint $table) {
            $table->foreignId('member_id')->after('key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_lookups', function (Blueprint $table) {
            //
        });
    }
}
