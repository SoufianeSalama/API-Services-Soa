<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('userid');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    // uitleg extra kolom userid:
    // 2 verschillende users:
    //  User 1: een hersteller die op locatie bij klanten toestellen gaat ophalen/terugbrengen/mogelijk herstellen
    //          deze krijgen een ander scherm te zien dan user 2 (google maps api)
    //  User 2: een hersteller die op het bedrijf toestellen gaan herstellen

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
