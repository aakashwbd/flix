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
            $table->integer('user_role_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('username')->nullable();
            $table->string('dob')->nullable();
            $table->string('age')->nullable();
            $table->string('address')->nullable();
            $table->string('presentation')->nullable();
            $table->string('image')->nullable();
            $table->string('type')->nullable();
            $table->string('preference')->nullable();
            $table->string('test')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('provider')->nullable();
            $table->string('last_seen')->nullable();
            $table->boolean('online_status')->default(false);
            $table->enum('status', ['active', 'pending', 'suspend', 'inactive'])->default('active');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
};
