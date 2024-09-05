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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('orderNumber');
            $table->string('orderId');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('total');
            $table->string('shipping');
            $table->string('tax');
            $table->string('discount');
            $table->string('steadFastAmount')->nullable();
            $table->boolean('steadFastSend')->nullable()->default(false);
            $table->string('steadFastId')->nullable();
            $table->string('steadFastStatus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
