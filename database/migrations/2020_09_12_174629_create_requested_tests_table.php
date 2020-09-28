<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestedTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id')->index();
            $table->unsignedBigInteger('test_id')->index();
            $table->enum('doable', ['yes', 'no', 'pending'])->default('pending');
            $table->boolean('complete')->default(false);

            // Foreign Keys
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('CASCADE');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('CASCADE');
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
        Schema::dropIfExists('requested_tests');
    }
}
