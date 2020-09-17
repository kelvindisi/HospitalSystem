<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id')->index();
            $table->unsignedBigInteger('drug_id')->index();
            $table->enum('availability', ['yes', 'no', 'pending'])->default('pending');
            $table->integer('quantity')->default(1);
            $table->enum('paid', ['yes', 'no', 'pending'])->default('pending');
            $table->boolean('issued')->default(false);

            // Foreign key
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('CASCADE');
            $table->foreign('drug_id')->references('id')->on('drugs')->onDelete('CASCADE');
            
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
        Schema::dropIfExists('prescriptions');
    }
}
