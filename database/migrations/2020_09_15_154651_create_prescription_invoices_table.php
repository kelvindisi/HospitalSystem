<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id')->unique()->index();
            $table->enum('paid', ['yes', 'no', 'pending'])->default('pending');
            $table->float('amount');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('CASCADE');
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
        Schema::dropIfExists('prescription_invoices');
    }
}
