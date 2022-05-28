<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 20)->uniqid();
            $table->string('username', 50)->uniqid()->nullable();
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->foreignId('gender_id')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->date('birthday')->nullable();
            $table->string('image', 50)->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('school')->nullable();
            $table->string('level')->nullable();
            $table->string('matric_no')->nullable();
            $table->string('course_study')->nullable();
            $table->rememberToken();
         
            $table->boolean('active')->default(1);
            $table->timestamps();

            $table->foreign('gender_id')->references('id')->on('genders')->onDelete(null);
           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
