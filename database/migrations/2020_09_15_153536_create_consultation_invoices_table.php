<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id')->index();
            $table->enum('paid', ['yes', 'no', 'pending'])->default('pending');
            $table->float('amount');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('CASCADE');
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
        Schema::dropIfExists('consultation_invoices');
    }
}
