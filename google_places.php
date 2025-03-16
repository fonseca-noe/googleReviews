<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// API Key de Google Places TU_API_KEY
define("API_KEY", "TU_API_KEY");

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
        return;
    }

    echo $response;
}

// Obtener reseñas de un negocio por su Place ID
function obtenerReseñas($placeId) {
    $apiKey = API_KEY;
    $url = "https://places.googleapis.com/v1/places/$placeId?key=$apiKey&fields=displayName,formattedAddress,photos,nationalPhoneNumber,websiteUri,internationalPhoneNumber,rating,reviews&languageCode=es";
    
    $response = file_get_contents($url);

    if ($response === FALSE) {
        echo json_encode(["error" => "No se pudieron obtener los datos del negocio."]);
        return;
    }
    $data = json_decode($response, true);
    // Procesar fotos para generar URLs
    if (!empty($data['photos'])) {
        foreach ($data['photos'] as $index => $photo) {
            $photoName = $photo['name'];
            $data['photos'][$index]['url'] = "https://places.googleapis.com/v1/{$photoName}/media?key=$apiKey&maxWidthPx=800";
        }
    }
    echo json_encode($data);
}
?>
