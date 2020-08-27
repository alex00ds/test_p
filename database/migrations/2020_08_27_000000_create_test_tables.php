<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('login', 30);
            $table->string('email', 191)->unique();
            $table->string('password', 191);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('wallets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('balance')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('wallet_id')->unsigned()->nullable(false);
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->double('balance')->default(0);
            $table->double('invested')->default(0);
            $table->double('percent')->default(0);
            $table->smallInteger('active')->index();
            $table->smallInteger('duration');
            $table->smallInteger('accrue_times');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 30);
            $table->integer('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('wallet_id')->unsigned()->nullable(false);
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->integer('deposit_id')->unsigned()->nullable();
            $table->foreign('deposit_id')->references('id')->on('deposits')->onDelete('set null');
            $table->double('amount')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('deposits');
        Schema::dropIfExists('wallets');
        Schema::dropIfExists('users');
    }
}
