<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (Schema::hasColumn('pedidos', 'carrito')) {
                $table->dropColumn('carrito');
            }
            if (Schema::hasColumn('pedidos', 'productos')) {
                $table->dropColumn('productos');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->json('carrito')->nullable();
            $table->json('productos')->nullable();
        });
    }
};
