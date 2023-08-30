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
        Schema::create('storage_units', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_id');
            $table->string('warehouse_name');
            $table->string('location');
            $table->timestamps();
            //ngentot
            // $table->unsignedBigInteger('vendor_id');
            // // $table->integer('vendor_id')->unsigned();
            // $table->foreign('vendor_id')->references('vendor_id')->on('vendors')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storage_units', function (Blueprint $table) {
            //
        });
    }
};
