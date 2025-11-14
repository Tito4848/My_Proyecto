<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pedido_plato', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plato_id')->constrained()->cascadeOnDelete();
            $table->integer('cantidad')->default(1);
            $table->decimal('precio', 8, 2);
            $table->timestamps();
        });
    }

};
