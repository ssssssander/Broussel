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
            $table->string('password')->nullable();
            $table->string('avatar_path')->default('/storage/uploads/avatars/default.png');
            $table->enum('role', ['user', 'buddy', 'admin'])->default('user');
            $table->enum('status', ['undecided', 'declined', 'accepted'])->nullable();
            $table->boolean('nl')->nullable();
            $table->boolean('fr')->nullable();
            $table->boolean('en')->nullable();
            $table->text('motivation')->nullable();
            $table->text('info')->nullable();
            $table->text('available_times')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
