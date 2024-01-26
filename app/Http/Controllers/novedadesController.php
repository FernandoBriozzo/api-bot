<?php

namespace App\Http\Controllers;

use App\Models\Apis\BarrioZip;
use App\Models\Apis\CalleZip;
use App\Models\Apis\PersonaZip;
use Illuminate\Http\Request;
use ZipArchive;

class novedadesController extends Controller
{
    public function showBarrios(Request $request)
    {
        if ($request["fecha_hasta"] < $request["fecha_desde"]) {
            return response()->json([
                "mensaje" => "La fecha inicial debe ser inferior a la fecha final."
            ], 400);
        } else {
            $barrios = BarrioZip::getBarriosByFecha($request["fecha_desde"], $request["fecha_hasta"]);
            $response = [];
            foreach ($barrios as $barrio) {
                $b["Id"] = $barrio->id_renabap;
                $b["nombre"] = $barrio->nombre_barrio;
                $b["fecha_actualizacion"] = $barrio->fecha_ultima_actualizacion;
                $b["url"] = "https://bot.integral.ar/proyectos/api-bot/public/zips/barrios/barrio-$barrio->id_renabap.zip";

                $response[] = $b;
            }
            return response()->json(
                $response,
                200
            );
        }
    }

    public function showPersonas()
    {
        $barrios = PersonaZip::getBarriosNovedades();
        $response = [];
        foreach ($barrios as $barrio) {
            $b["Id"] = $barrio;
            $b["url"] = "https://bot.integral.ar/proyectos/api-bot/public/zips/personas/personas-barrio-$barrio.zip";
            $response[] = $b;
        }
        return response()->json(
            $response,
            200
        );
    }

    public function makeZipBarrios(BarrioZip $barrio)
    {
        //crear json barrios

        $geojsonBarrio["type"] = "FeatureCollection";
        $geojsonBarrio["name"] = "barrios";
        $features["type"] = "Feature";
        $features["properties"]["id_renabap"]  = $barrio->id_renabap;
        $features["properties"]["nombre_barrio"] = $barrio->nombre_barrio;
        $features["properties"]["id_prov"] = $barrio->id_prov;
        $features["properties"]["provincia"] = $barrio->provincia;
        $features["properties"]["id_dpto"] = $barrio->id_dpto;
        $features["properties"]["departamento"] = $barrio->departamento;
        $features["properties"]["id_localidad"] = $barrio->id_localidad;
        $features["properties"]["localidad"] = $barrio->localidad;
        $features["geometry"] = $barrio->getGeom();
        $geojsonBarrio["features"][] = $features;

        //crear json calles

        $calles = CalleZip::getCallesById($barrio->id_renabap);

        $geojsonCalles["type"] = "FeatureCollection";
        $geojsonCalles["name"] = "Calles";

        foreach ($calles as $calle) {
            $features = [];
            $features["type"] = "Feature";
            $features["properties"]["id"]  = $calle->id;
            $features["properties"]["nombre"] = $calle->nombre;
            $features["properties"]["id_renabap"] = $barrio->id_renabap;
            $features["geometry"] = $calle->getGeom();
            $geojsonCalles["features"][] = $features;
        }

        //crear json manzanas

        $manzanas = $barrio->manzanas;

        $geojsonManzanas["type"] = "FeatureCollection";
        $geojsonManzanas["name"] = "manzanas";

        foreach ($manzanas as $manzana) {
            $features = [];
            $features["type"] = "Feature";
            $features["properties"]["id_manzana"]  = $manzana->id_manzana;
            $features["properties"]["id_renabap"] = $manzana->id_renabap;
            $features["properties"]["manzana"] = $manzana->manzana;
            $features["geometry"] = $manzana->getGeom();
            $geojsonManzanas["features"][] = $features;
        }

        //crear json terrenos

        $geojsonTerrenos["type"] = "FeatureCollection";
        $geojsonTerrenos["name"] = "terrenos";

        foreach ($manzanas as $manzana) {
            foreach ($manzana->terrenos as $terreno) {
                $features = [];
                $features["type"] = "Feature";
                $features["properties"]["id_terreno"]  = $terreno->id_terreno;
                $features["properties"]["id_manzana"] = $terreno->id_manzana;
                $features["properties"]["terreno"] = $terreno->terreno;
                $features["properties"]["tipo_terreno"] = $terreno->tipo_terreno;
                $features["geometry"] = $terreno->getGeom();
                $geojsonTerrenos["features"][] = $features;
            }
        }

        //crear json edificaciones

        $geojsonEdificaciones["type"] = "FeatureCollection";
        $geojsonEdificaciones["name"] = "edificaciones";

        foreach ($manzanas as $manzana) {
            foreach ($manzana->terrenos as $terreno) {
                foreach ($terreno->edificaciones as $edificacion) {
                    $features = [];
                    $features["type"] = "Feature";
                    $features["properties"]["id_edificacion"]  = $edificacion->id_edificacion;
                    $features["properties"]["id_terreno"] = $edificacion->id_terreno;
                    $features["properties"]["nro_edificacion"] = $edificacion->nro_edificacion;
                    $features["properties"]["tipo_edificacion"] = $edificacion->tipo_edificacion;
                    $features["properties"]["nro_total_viviendas"] = $edificacion->nro_total_viviendas;
                    $features["geometry"] = $edificacion->getGeom();
                    $geojsonEdificaciones["features"][] = $features;
                }
            }
        }

        $zip = new ZipArchive();
        $filename = "./zips/barrios/barrio-$barrio->id_renabap.zip";

        if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
            exit("No se puede crear el arhivo del barrio: $barrio->nombre_barrio ($barrio->id_renabap).");
        } else {
            $zip->addFromString("Barrios.geojson", json_encode($geojsonBarrio));
            $zip->addFromString("Calles.geojson", json_encode($geojsonCalles));
            $zip->addFromString("Manzanas.geojson", json_encode($geojsonManzanas));
            $zip->addFromString("Terrenos.geojson", json_encode($geojsonTerrenos));
            $zip->addFromString("Edificaciones.geojson", json_encode($geojsonEdificaciones));
            $zip->close();
            $filehandler = fopen("./zips/barrios/$barrio->id_renabap.txt", 'w');
            fwrite($filehandler, $barrio->fecha_ultima_actualizacion);
            fclose($filehandler);
            echo "Archivo de barrio: $barrio->nombre_barrio ($barrio->id_renabap) creado/actualizado con éxito.";
        }
    }

    public function actualizarBarrios()
    {
        $barrios = BarrioZip::all();
        foreach ($barrios as $barrio) {
            if (file_exists("./zips/barrios/$barrio->id_renabap.txt")) {
                $filepath = "./zips/barrios/$barrio->id_renabap.txt";
                $filehandler = fopen($filepath, "r");
                $fecha = fread($filehandler, filesize($filepath));
                fclose($filehandler);
                if ($fecha < $barrio->fecha_ultima_actualizacion) {
                    $this->makeZipBarrios($barrio);
                } else {
                    echo "Archivo de barrio: $barrio->nombre_barrio($barrio->id_renabap) no actualizado";
                }
            } else {
                $this->makeZipBarrios($barrio);
            }
        }
    }

    public function makeZipPersonas($id)
    {
        $barrio = BarrioZip::find($id);
        $cvfs = PersonaZip::getCertificadosByBarrio($barrio);
        $personas = [];
        foreach ($cvfs as $cvf) {
            $personas[$cvf] = PersonaZip::getPersonasByCertificado($cvf);
        }
        if (count($personas) > 0) {
            $zip = new ZipArchive();
            $filename = "./zips/personas/personas-barrio-$barrio->id_renabap.zip";

            if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
                exit("No se puede crear el arhivo con las personas del barrio: $barrio->nombre_barrio ($barrio->id_renabap).");
            } else {
                $zip->addFromString("Personas.json", json_encode($personas));
                $zip->close();
                echo "Archivo de las personas del barrio: $barrio->nombre_barrio ($barrio->id_renabap) creado/actualizado con éxito.";
            }
        }
    }

    public function actualizarPersonas()
    {
        $barrios = PersonaZip::getBarriosNovedades();
        foreach ($barrios as $barrio) {
            $this->makeZipPersonas($barrio);
        }
    }
}
