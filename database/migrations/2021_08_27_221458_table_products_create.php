<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TableProductsCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('productId');
            $table->string('name');
            $table->text('description');
            $table->integer('company_id');
            $table->string('company_name');
            $table->integer('stock');
            $table->text('images');
            $table->decimal('price');
            $table->integer('sku');
            $table->text('categories_id');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE products ADD FULLTEXT full(name, description, company_name)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
