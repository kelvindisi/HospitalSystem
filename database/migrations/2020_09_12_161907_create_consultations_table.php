<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('payment_mode_id');
            $table->enum('status',['pending', 'test', 'seen'])->default('pending');
            $table->boolean('test_ready')->default(true);
            $table->text('diagnosis')->nullable(true);

            // Foreign Keys
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('CASCADE');
            $table->foreign('payment_mode_id')->references('id')->on('payment_modes')->onDelete('CASCADE');
            
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
        Schema::dropIfExists('consultations');
    }
}
