<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('consultation_id')->nullable(true)->index();
            $table->unsignedBigInteger('prescription_id')->nullable(true)->index();
            $table->unsignedBigInteger('test_id')->nullable(true)->index();
            $table->float('amount');
            $table->enum('cleared', ['yes', 'no', 'pending'])->default('pending');

            // Foreign Key
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('CASCADE');
            $table->foreign('test_id')->references('id')->on('requested_tests')->onDelete('CASCADE');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('CASCADE');

            $table->boolean('paid')->default(false);
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
        Schema::dropIfExists('invoices');
    }
}
