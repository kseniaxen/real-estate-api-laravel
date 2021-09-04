<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('type_propertyId');
            $table->unsignedBigInteger('typeId');
            $table->unsignedBigInteger('countryId');
            $table->unsignedBigInteger('cityId');
            $table->unsignedBigInteger('currencyId');
            $table->unsignedBigInteger('unitId');
            $table->unsignedTinyInteger('rooms');
            $table->unsignedFloat('area');
            $table->unsignedFloat('residential_area')->nullable();
            $table->unsignedFloat('kitchen_area')->nullable();
            $table->unsignedFloat('land_area');
            $table->unsignedTinyInteger('floors');
            $table->decimal('price',15,2);
            $table->string('description')->nullable();
            $table->string('title');
            $table->string('name');
            $table->unsignedBigInteger('phone');
            $table->longText('image')->nullable();
            $table->timestamps();

            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_propertyId')->references('id')->on('type_properties')->onDelete('cascade');
            $table->foreign('typeId')->references('id')->on('types')->onDelete('cascade');
            $table->foreign('countryId')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('cityId')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('currencyId')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('unitId')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houses');
    }
}
