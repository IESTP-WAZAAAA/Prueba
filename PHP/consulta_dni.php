<?php
// Configuración
$token = 'apis-token-12824.HUAGGkHXJjln9Sdw3h8p8Nh9DHrKFe2N';
$dni = $_REQUEST['dni'];

// Se valida el DNI
if (!preg_match('/^\d{8}$/', $dni)) {
    die(json_encode(['error' => 'El DNI no es válido.']));
}

// Se inicia la llamada a la API
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $dni,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => 1, 
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 2,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Referer: https://apis.net.pe/consulta-dni-api',
        'Authorization: Bearer ' . $token
    ),
));

// Se ejecutar consulta
$response = curl_exec($curl);

// Manejar errores de CURL
if (curl_errno($curl)) {
    die(json_encode(['error' => 'Error en la conexión: ' . curl_error($curl)]));
}

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

// Validar respuesta de la API
if ($httpCode !== 200) {
    die(json_encode(['error' => 'Error al consultar la API, código: ' . $httpCode]));
}

echo $response;
?>
