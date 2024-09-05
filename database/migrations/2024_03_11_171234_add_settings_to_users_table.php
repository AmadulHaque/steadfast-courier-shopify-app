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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('appStatus')->default(false);
            $table->string('apiKey')->nullable();
            $table->string('secretKey')->nullable();
            $table->string('businessName')->nullable();
            $table->string('businessAddress')->nullable();
            $table->string('businessEmail')->nullable();
            $table->string('businessNumber')->nullable();
            $table->string('businessLogo')->nullable();
            $table->longText('businessTerms')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
