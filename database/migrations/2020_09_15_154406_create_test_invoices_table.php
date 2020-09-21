<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requested_test_id')->unique()->index();
            $table->enum('paid', ['yes', 'no', 'pending'])->default('pending');
            $table->float('amount');

            $table->foreign('requested_test_id')->references('id')->on('requested_tests')->onDelete('CASCADE');
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
        Schema::dropIfExists('test_invoices');
    }
}
