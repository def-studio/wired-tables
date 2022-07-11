<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->json('data');
            $table->boolean('broken')->default(0);

            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();


            $table->nullableMorphs('trailable');

            $table->timestamps();
        });
    }
};
