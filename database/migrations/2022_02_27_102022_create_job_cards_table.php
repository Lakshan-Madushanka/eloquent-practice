<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_cards', function (Blueprint $table) {
            $table->id();
            $table->char('job_comp_code', 1);
            $table->integer('job_enq_no');
            $table->date('job_received_date');
            $table->date('job_invoice_date')->nullable();
            $table->integer('job_invoice_amount')->nullable();
            $table->enum('job_status', ['invoiced', 'received']);
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
        Schema::dropIfExists('job_cards');
    }
}
