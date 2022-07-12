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
        Schema::create('upsellfunnel_downsellproducts', function (Blueprint $table) {
            $table->id();
            $table->integer('funnelid');
            $table->integer('upsellid');
            $table->enum('dntype', ['Downsell']);
            $table->string('dnshopify_productid');
            $table->string('dnshopify_productname');
            $table->string('dnshopify_producthandle');
            $table->enum('dndiscounttype', ['Percentage', 'Fixed']);
            $table->enum('dnstatus', ['Enable', 'Disable'])->default('Disable');
            $table->string('dndiscountamount');
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
        Schema::dropIfExists('upsellfunnel_downsellproducts');
    }
};
