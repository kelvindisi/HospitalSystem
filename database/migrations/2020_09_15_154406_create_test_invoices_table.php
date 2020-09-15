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
            $table->unsignedBigInteger('test_id')->index();
            $table->enum('paid', ['yes', 'no', 'pending'])->default('pending');

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
        Schema::dropIfExists('test_invoices');
    }
}
