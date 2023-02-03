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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('make')->nullable();
            $table->string('brand');
            $table->string('model');
            $table->year('year_start')->nullable();
            $table->year('year_end')->nullable();
            $table->string('transmission');
            $table->integer('thickness_number');
            $table->string('thickness');
            $table->string('stock_number')->nullable();
            $table->integer('enterex_price')->nullable();
            $table->integer('price');
            $table->text('notes')->nullable();
            $table->integer('quantity')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
