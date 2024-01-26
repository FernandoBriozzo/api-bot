<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;
use Ramsey\Uuid\Type\Integer;

use function PHPUnit\Framework\isEmpty;

class RenaperController extends Controller
{
    public function generateToken()
    {
        $user = env("RENAPER_USER");
        $password = env("RENAPER_PASS");
        $endpoint = "/Autorizacion/token.php";
        $url = env("RENAPER_URL") . $endpoint;
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";

        $body = [
            "username" => $user,
            "password" => $password
        ];
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query($body)
        ]);
        $response = json_decode(curl_exec($ch), true);
        unset($ch);
        if ($response["codigo"] == 200) {
            return response()->json([
                "mensaje" => $response["mensaje"],
                "token" => $response["token"]
            ], 200);
        } else {
            return response()->json([
                "mensaje" => $response["mensaje"],
            ], $response["codigo"]);
        }
    }

    public function getPerson(Request $request)
    {
        $url = env("RENAPER_URL") . "/datosc.php?sexo=" . $request["sexo"] . "&dni=" . $request["dni"];
        $token = $request["token"];
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_HTTPHEADER => array(
                "authorization: bearer $token",
                "cache-control: no-cache"
            )
        ]);
        $response = json_decode(curl_exec($ch), true);
        unset($ch);
        if (empty($response)) {
            return response()->json([], 204);
        } else if ($response["codigo"] == 200) {
            return response()->json([
                "mensaje" => $response["mensaje"],
                "data" => $response["data"]
            ], 200);
        } else {
            return response()->json([
                "mensaje" => $response["mensaje"],
            ], $response["codigo"]);
        }
    }
}
