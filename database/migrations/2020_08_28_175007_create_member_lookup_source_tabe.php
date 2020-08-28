<?php

use App\Models\MemberLookup;
use App\Models\MemberLookupSource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberLookupSourceTabe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_lookup_sources', function (Blueprint $table) {
            $table->id();
            $table->string('source', 16);
            $table->timestamps();
        });

        MemberLookupSource::query()->create([
            'source' => 'Member Created',
        ]);

        MemberLookupSource::query()->create([
            'source' => 'From Booking',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_lookup_sources');
    }
}
