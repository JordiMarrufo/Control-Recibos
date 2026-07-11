<?php

namespace App\Http\Controllers;

use App\Models\PagoMensual;
use Illuminate\Http\Request;

class PagoMensual_Controller extends Controller
{
    public function index()
    {
        $pagos = PagoMensual::with('inquilino')->get();

        return response()->json($pagos);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'inquilino_id' => 'required|exists:inquilino,id',
            'monto_agua' => 'required|numeric',
            'agua_pagado' => 'boolean',
            'monto_luz' => 'required|numeric',
            'luz_pagado' => 'boolean',
            'mensual_monto' => 'required|numeric',
            'mensual_pagado' => 'boolean',
        ]);


        $pago = PagoMensual::create($validated);


        return response()->json([
            'message' => 'Pago creado correctamente',
            'data' => $pago
        ]);
    }


    public function show(PagoMensual $pagoMensualinquilino)
    {
        return response()->json(
            $pagoMensualinquilino->load('inquilino')
        );
    }


    public function edit(PagoMensual $pagoMensualinquilino)
    {
        //
    }


    public function update(Request $request, PagoMensual $pagoMensualinquilino)
    {
        $validated = $request->validate([
            'monto_agua' => 'sometimes|numeric',
            'agua_pagado' => 'sometimes|boolean',
            'monto_luz' => 'sometimes|numeric',
            'luz_pagado' => 'sometimes|boolean',
            'mensual_monto' => 'sometimes|numeric',
            'mensual_pagado' => 'sometimes|boolean',
        ]);


        $pagoMensualinquilino->update($validated);


        return response()->json([
            'message' => 'Pago actualizado correctamente',
            'data' => $pagoMensualinquilino
        ]);
    }


    public function destroy(PagoMensual $pagoMensualinquilino)
    {
        $pagoMensualinquilino->delete();


        return response()->json([
            'message' => 'Pago eliminado correctamente'
        ]);
    }
}