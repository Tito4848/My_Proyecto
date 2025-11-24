<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->enum('estado_seguimiento', ['recibido', 'preparando', 'listo', 'en_camino', 'entregado'])->default('recibido')->after('estado');
            $table->timestamp('fecha_recibido')->nullable()->after('estado_seguimiento');
            $table->timestamp('fecha_preparando')->nullable()->after('fecha_recibido');
            $table->timestamp('fecha_listo')->nullable()->after('fecha_preparando');
            $table->timestamp('fecha_en_camino')->nullable()->after('fecha_listo');
            $table->timestamp('fecha_entregado')->nullable()->after('fecha_en_camino');
            $table->string('codigo_seguimiento')->unique()->nullable()->after('fecha_entregado');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'estado_seguimiento',
                'fecha_recibido',
                'fecha_preparando',
                'fecha_listo',
                'fecha_en_camino',
                'fecha_entregado',
                'codigo_seguimiento'
            ]);
        });
    }
};

