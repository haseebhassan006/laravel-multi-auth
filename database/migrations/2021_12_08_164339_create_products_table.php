<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->double('price')->nullable();
            $table->double('discount_percent')->nullable();
            $table->string('status')->nullable();
            $table->string('stock_status')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('image')->nullable();
            $table->integer('views');
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
        Schema::dropIfExists('products');
    }
}
