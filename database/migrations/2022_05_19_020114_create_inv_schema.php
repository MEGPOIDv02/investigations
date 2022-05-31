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
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->rememberToken();
            $table->timestamps();

            $table->unsignedInteger('fk_id_role');

            $table->foreign('fk_id_role')
                ->references('id')
                ->on('roles');

        });

        Schema::create('inv_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('stimulation_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('signs_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('investigations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('effects');
            $table->string('duration');
            $table->string('frecuenty');
            $table->string('intensity');
            $table->string('time');
            $table->string('colocation');
            $table->string('document');
            $table->boolean('concent');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unsignedInteger('fk_id_inv_type');
            $table->unsignedInteger('fk_id_inv_stimulation_type');
            $table->unsignedInteger('fk_id_inv_sign_type');

            $table->foreign('fk_id_inv_type')
                ->references('id')
                ->on('inv_type');

            $table->foreign('fk_id_inv_stimulation_type')
                ->references('id')
                ->on('stimulation_type');

            $table->foreign('fk_id_inv_sign_type')
                ->references('id')
                ->on('signs_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investigations');
        Schema::dropIfExists('signs_type');
        Schema::dropIfExists('stimulation_type');
        Schema::dropIfExists('inv_type');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
