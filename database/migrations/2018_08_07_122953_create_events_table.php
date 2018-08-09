<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create events table
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->text('description');
            $table->dateTime('date');
            $table->enum('category', ['Sport', 'Culture', 'Other']);
            $table->timestamps();
            $table->unsignedInteger('event_organiser');
            
            //create indexes
            $table->foreign('event_organiser')->references('id')->on('users');
            $table->index('name');
            $table->index('category');
            $table->index('date');
        });
        
        //Table to link events and users many-to-many
        Schema::create('user_event_intrests', function (Blueprint $table) {
            $table->unsignedInteger('userId');
            $table->unsignedInteger('eventId');
            
            $table->primary(['userId', 'eventId']);
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('eventId')->references('id')->on('events');
            
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //remove all foreign keys before deleting
        Schema::table('user_event_intrests', function (Blueprint $table) {
           $table->dropForeign('userId');
           $table->dropForeign('eventId');
        });
        Schema::dropIfExists('events');
        
        //remove all foreign keys before deleting
        Schema::table('events', function (Blueprint $table) {
           $table->dropForeign('event_organiser');
        });
        Schema::dropIfExists('events');
    }
}
