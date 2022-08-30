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
            $table->string('name');
            $table->string('short_description');
            $table->string('description');
            $table->date('start_at');
            $table->date('end_at');
            $table->foreignId('category_id');
            $table->json('max_team_number')->nullable();
            $table->string('award')->nullable();
            $table->string('image', 50)->nullable();
            $table->timestamps();

            
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
