<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name',50);
            $table->string('surname',50);
            $table->string('email',50)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username',100)->unique();
            $table->string('password')->nullable();
            $table->rememberToken()->nullable();
            $table->string('series_id')->nullable();
            $table->datetime('expires')->nullable();
             $table->enum('team', ['Mamateam 2.0', 'Cantera'])->default('Mamateam 2.0');
            $table->string('avatar', 64)->default('profile-1.webp');
            $table->string('phone', 15)->nullable();
            $table->string('account_facebook', 50)->nullable();
            $table->string('account_instagram', 50)->nullable();
            $table->string('address')->nullable();
            $table->date('birthday')->nullable();
            $table->datetime('lastaccess')->nullable();
            $table->boolean('active')->default(false);
            $table->datetime('created_at');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
