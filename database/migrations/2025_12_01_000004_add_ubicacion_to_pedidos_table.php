<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->decimal('latitud', 10, 8)->nullable()->after('codigo_seguimiento');
            $table->decimal('longitud', 11, 8)->nullable()->after('latitud');
            $table->string('direccion_entrega')->nullable()->after('longitud');
            $table->timestamp('ultima_actualizacion_ubicacion')->nullable()->after('direccion_entrega');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'latitud',
                'longitud',
                'direccion_entrega',
                'ultima_actualizacion_ubicacion'
            ]);
        });
    }
};

