<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (!Schema::hasColumn('pedidos', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('pedidos', 'estado')) {
                $table->string('estado')->default('pendiente');
            }
            if (!Schema::hasColumn('pedidos', 'total')) {
                $table->decimal('total', 8, 2)->default(0);
            }
        });
    }

};
