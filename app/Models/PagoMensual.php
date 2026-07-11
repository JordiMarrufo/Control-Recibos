<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PagoMensual extends Model
{
    use HasFactory;

    protected $table = 'pago_mensual';

    protected $fillable = [
        'inquilino_id',
        'monto_agua',
        'agua_pagado',
        'monto_luz',
        'luz_pagado',
        'fecha_pagado',
    ];

    protected $casts = [
        'agua_pagado' => 'boolean',
        'luz_pagado' => 'boolean',
        'fecha_pagado' => 'boolean',
        'monto_agua' => 'decimal:2',
        'monto_luz' => 'decimal:2',
    ];

    public function inquilino()
    {
        return $this->belongsTo(Inquilino::class);
    }
}