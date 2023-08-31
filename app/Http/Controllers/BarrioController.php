<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apis\Barrio;

class BarrioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barrios = Barrio::all();
        if ($barrios !== null) {
            $response = [];
            foreach ($barrios as $barrio) {
                if (count($response) == 10) break;
                $response[] = array(
                    'id-barrio' => $barrio->id_renabap,
                    'nombre-barrio' => $barrio->nombre_barrio,
                    'localidad' => $barrio->localidad(),
                    'departamento' => $barrio->departamento(),
                    'provincia' => $barrio->provincia()
                );
            }
            return response()->json([
                $response
            ], 200);
        } else {
            return response()->json([], 204);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barrio = Barrio::find($id);
        if ($barrio !== null) {
            return response()->json([
                $barrio
            ], 200);
        } else {
            return response()->json([], 204);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function geometria($id) {
        $barrio = Barrio::find($id);
        if ($barrio != null) {
            $geometry = $barrio->geometry;
            return response()->json([
                'id-barrio' => $barrio->id_renabap,
                'nombre-barrio' => $barrio->nombre_barrio,
                'geometria' => $geometry->geom
            ]
            , 200);
        } else {
            return response()->json([], 204);
        }
        return response()->json([
            'geometria' => $id
        ], 200);
    }

    public function ubicacion($id) {
        $barrio = Barrio::find($id);
        return response()->json([
            'nombre-barrio' => $barrio->nombre_barrio,
            'localidad' => $barrio->localidad(),
            'departamento' => $barrio->departamento(),
            'provincia' => $barrio->provincia()
        ], 200);
    }
}
