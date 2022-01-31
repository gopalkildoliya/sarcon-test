<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('detail')->nullable();
            $table->string('speaker')->nullable();
            $table->string('speaker_designation')->nullable();
            $table->string('speaker_company')->nullable();
            $table->string('speaker_image')->nullable();
            $table->integer('rating')->nullable();
            $table->string('time')->nullable();
            $table->boolean('audience_can_join')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_sessions');
    }
}
