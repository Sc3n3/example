<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('creator_id')->unsigned();
            $table->bigInteger('agent_id')->unsigned()->nullable();
            $table->bigInteger('office_id')->unsigned()->nullable();
            $table->bigInteger('contact_id')->unsigned()->nullable();
            $table->bigInteger('property_id')->unsigned()->nullable();
            $table->timestamp('date');
            $table->bigInteger('distance')->nullable();
            $table->bigInteger('eta')->nullable();
            $table->timestamp('departure')->nullable();
            $table->timestamp('arrival')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');

            $table->foreign('office_id')
                ->references('id')
                ->on('offices')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');

            $table->foreign('agent_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');

            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');

            $table->foreign('property_id')
                ->references('id')
                ->on('properties')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
