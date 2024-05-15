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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();
            $table->string('code')->nullable();;
            $table->string('cuit')->nullable();
            $table->string('shop')->nullable();
            $table->string('fapiusr');
            $table->string('fapiclave');
            $table->string('hmac')->nullable();
            $table->string('host')->nullable();
            $table->string('state')->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
