<?php

namespace App\Http\Controllers;

use App\Models\Inquilino;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Inquilino_Controller extends Controller
{
    /**
     * Mostrar todos los registros.
     */
    public function index()
    {
        return response()->json(Inquilino::all());
    }

    /**
     * Guardar un nuevo registro.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|size:9|unique:inquilino,telefono',
            'dni' => 'required|string|max:20|unique:inquilino,dni',
            'correo' => 'required|email|unique:inquilino,correo',
            'cuota' => 'required',
            'fecha_ingreso' => 'required|date',
        ]);

        $inquilino = Inquilino::create($validated);

        return response()->json([
            'message' => 'Inquilino registrado correctamente.',
            'data' => $inquilino
        ], 201);
    }

    /**
     * Mostrar un registro específico.
     */
    public function show(Inquilino $inquilino)
    {
        return response()->json($inquilino);
    }

    /**
     * Actualizar un registro.
     */
    public function update(Request $request, Inquilino $inquilinosback)
    {

        $validated = $request->validate([

            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],


            'apellido' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],


            'telefono' => [
                'sometimes',
                'required',
                'string',
                'size:9',
                Rule::unique('inquilino', 'telefono')
                    ->ignore($inquilinosback->id)
            ],


            'dni' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('inquilino', 'dni')
                    ->ignore($inquilinosback->id)
            ],


            'correo' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('inquilino', 'correo')
                    ->ignore($inquilinosback->id)
            ],


            'cuota' => [
                'sometimes',
                'required'
            ],


            'fecha_ingreso' => [
                'sometimes',
                'required',
                'date'
            ]

        ]);



        $inquilinosback->update($validated);



        return response()->json([

            'message' => 'Inquilino actualizado correctamente.',

            'data' => $inquilinosback

        ]);
    }

    /**
     * Eliminar un registro.
     */
    public function destroy(Inquilino $inquilinosback)
    {
        $inquilinosback->delete();

        return response()->json([
            'message' => 'Inquilino eliminado correctamente'
        ]);
    }
}
