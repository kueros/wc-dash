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
		Schema::create('woo_usr_milos', function (Blueprint $table) {
			$table->integer('id')->index('id');
			$table->string('id_tienda', 100);
			$table->string('usr_milo', 100);
			$table->string('psw_milo', 255);
			$table->string('CustomerCode', 10)->nullable();
			$table->string('FirstName', 100)->nullable();
			$table->string('LastName', 100)->nullable();
			$table->string('Telephone', 25)->nullable();
			$table->string('Email', 100)->nullable();
			$table->timestamps();
		});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('woo_usr_milo');
    }
};
