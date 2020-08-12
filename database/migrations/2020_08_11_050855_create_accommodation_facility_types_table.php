<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationFacilityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_facility_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accommodation_id');
            $table->unsignedBigInteger('facility_type_id');
            $table->string('message', 255)->nullable();
            $table->timestamps();

            $table->foreign('accommodation_id')
                ->references('id')
                ->on('accommodations');

            $table->foreign('facility_type_id')
                ->references('id')
                ->on('facility_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodation_facility_types');
    }
}
