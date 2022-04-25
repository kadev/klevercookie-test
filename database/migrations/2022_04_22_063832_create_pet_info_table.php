<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_info', function (Blueprint $table) {
            $table->id();
            $table->string('owner_email');
            $table->string('pet_name');
            $table->string('photo')->nullable();
            $table->string('gender');
            $table->string('is_spayed')->nullable();
            $table->string('is_neutered')->nullable();
            $table->string('is_pregnant')->nullable();
            $table->string('have_allergies');
            $table->string('allergies')->nullable();
            $table->string('other_allergies')->nullable();
            $table->string('breed');
            $table->string('birthdate')->nullable();
            $table->float('weight')->nullable();
            $table->float('ideal_weight')->nullable();
            $table->string('lifestyle');
            $table->string('goal');
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
        Schema::dropIfExists('pet_info');
    }
}
