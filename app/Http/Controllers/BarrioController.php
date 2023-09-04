<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apis\Barrio;
use App\Models\Apis\Provincia;
use Illuminate\Support\Facades\DB;

class BarrioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [];

        $barrios = DB::connection('arsat')->table('barrios')
            ->leftJoin('barrios_geom', 'barrios.id_renabap', '=', 'barrios_geom.id_renabap')
            ->join('localidades', 'barrios.id_loc_t2', '=', 'localidades.id_loc_t2')
            ->join('departamentos', DB::raw('substr(barrios.id_loc_t2, 1, 5)'), '=', 'departamentos.id_dpto')
            ->join('provincias', DB::raw('substr(barrios.id_loc_t2, 1, 2)'), '=', 'provincias.id_prov')
            ->select(
                'provincias.id_prov as id_provincia',
                'provincias.nombre as nombre_provincia',
                'departamentos.id_dpto as id_partido',
                'departamentos.nombre as nombre_partido',
                'localidades.id_loc_t2 as id_localidad', 
                'localidades.nombre as nombre_localidad', 
                'barrios.id_renabap as id_barrio',
                'barrios.nombre_barrio',
                DB::raw('public.ST_AsText(barrios_geom.geom) as geometry'))
            ->orderBy('barrios.id_renabap')
            ->get();
        
        $response['status'] = 'success';
        $response['result']['codigo'] = 100;
        $response['result']['detalle']['flag'] = true;
        $response['result']['detalle']['detalle'] = 'Entidades territoriales obtenidas exitosamente.';
        $response['result']['detalle']['mensaje'] = null;
        $response['result']['detalle']['datos']['datos'] = $barrios;
        $response['result']['detalle']['datos']['provincias'] = Provincia::select('id_prov as id_provincia', 'nombre as nombre_provincia')->orderBy('id_prov')->get();

        return response()->json($response, 200);

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
