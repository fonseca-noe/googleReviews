<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
//TU_API_KEY
// API Key de Google Places
define("API_KEY", "AIzaSyAiFBHR0Dk7c93JLCT266HW7K_ePhMtnyM");

$data = json_decode(file_get_contents("php://input"), true);
$tipo = $data["tipo"] ?? "";
$param = $data["param"] ?? "";

if ($tipo === "buscar") {
    buscarNegocio($param);
} elseif ($tipo === "reseñas") {
    obtenerReseñas($param);
} else {
    echo json_encode(["error" => "Solicitud inválida"]);
}

// Buscar negocios por nombre
function buscarNegocio($nombreNegocio) {
    $url = "https://places.googleapis.com/v1/places:searchText?key=" . API_KEY;

    $postData = json_encode([
        "textQuery" => $nombreNegocio,
        "languageCode" => "es", // Forzar idioma español
        "regionCode" => "PE" // Si buscas negocios en Perú, cambia según el país
    ]);

    $options = [
        "http" => [
            "header"  => "Content-Type: application/json\r\nX-Goog-FieldMask: places.id,places.displayName,places.formattedAddress\r\n",
            "method"  => "POST",
            "content" => $postData,
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        echo json_encode(["error" => "No se pudieron obtener los datos."]);
    } else {
        echo $response;
    }
}

//  Obtener reseñas de un negocio por su Place ID
function obtenerReseñas($placeId) {
    $url = "https://places.googleapis.com/v1/places/$placeId?key=" . API_KEY . "&fields=displayName,rating,reviews&languageCode=es";
    $response = file_get_contents($url);

    if ($response === FALSE) {
        echo json_encode(["error" => "No se pudieron obtener los datos del negocio."]);
    } else {
        echo $response;
    }
}
?>
