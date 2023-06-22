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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnDelete();            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->string('product');
            $table->decimal('amount_collection')->nullable();
            $table->decimal('amount_commission');
            $table->decimal('discount');
            $table->decimal('value_vat');
            $table->string('rate_vat');
            $table->decimal('total');
            $table->string('status',50);
            $table->integer('value_status');
            $table->date('payment_date')->nullable();
            $table->text('note')->nullable();
            $table->softDeletes();
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
};
