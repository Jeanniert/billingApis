<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onUpdate('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onUpdate('cascade');
            $table->json('product');
            $table->float('total', 8,2);
            $table->float('tax', 8,2)->nullable();
            $table->float('totalWithTax', 8,2)->nullable();
            $table->float('subtotal',8,2);
            $table->string('correlative')->unique();
            $table->string('date');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
