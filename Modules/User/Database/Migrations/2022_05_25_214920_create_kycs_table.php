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
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable();
            $table->string('identity_no', 20)->unique()->nullable();
            $table->string('identity_file', 50)->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('accepted')->default(1);
            $table->string('repo_link')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('intership_open')->nullable();
            $table->string('about_me')->nullable();
            $table->foreignId('verified_by_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('verified_by_id')->references('id')->on('admins');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kycs');
    }
};
