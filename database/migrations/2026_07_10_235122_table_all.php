<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inquilino', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('apellido');
            $table->string('telefono', 9)->unique();
            $table->string('dni')->unique();
            $table->string('correo')->unique();
            $table->string('cuota');
            $table->date('fecha_ingreso');
            $table->timestamps();
        });


        Schema::create('pago_mensual', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquilino_id')->constrained('inquilino');
            $table->decimal('monto_agua', 8, 2);
            $table->boolean('agua_pagado')->default(false);
            $table->decimal('monto_luz', 8, 2);
            $table->boolean('luz_pagado')->default(false);
            $table->boolean('fecha_pagado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
