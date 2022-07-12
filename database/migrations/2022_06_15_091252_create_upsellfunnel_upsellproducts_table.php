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
        Schema::create('upsellfunnel_upsellproducts', function (Blueprint $table) {
            $table->id();
            $table->integer('funnelid');
            $table->enum('uptype', ['Upsell']);
            $table->string('upshopify_productid');
            $table->string('upshopify_productname');
            $table->string('upshopify_producthandle');
            $table->enum('updiscounttype', ['Percentage', 'Fixed']);
            $table->enum('upstatus', ['Enable', 'Disable'])->default('Disable');
            $table->string('updiscountamount');
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
        Schema::dropIfExists('upsellfunnel_upsellproducts');
    }
};
