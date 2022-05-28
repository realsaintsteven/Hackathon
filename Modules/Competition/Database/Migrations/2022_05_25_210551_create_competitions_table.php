<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_type_id');
            $table->string('name');
            $table->string('short_description');
            $table->string('description');
            $table->date('start_at');
            $table->date('end_at');
            $table->json('max_team_number')->nullable();
            $table->string('award')->nullable();
            $table->timestamps();

            
            $table->foreign('competition_type_id')->references('id')->on('competition_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitions');
    }
};
