<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données JSON de la requête POST
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data === null) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
        exit;
    }

    // Chemin du fichier saves.json
    $savesFile = '/var/www/html/escape-game/saves.json';

    // Lire le contenu actuel de saves.json
    if (file_exists($savesFile)) {
        $saves = json_decode(file_get_contents($savesFile), true);
    } else {
        $saves = [];
    }

    // Vérifier si la lecture a réussi
    if ($saves === null) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Could not read saves file']);
        exit;
    }

    // Mettre à jour les données
    $saves['epreuve1'] = $data['epreuve1'];

    // Écrire les nouvelles données dans saves.json
    if (file_put_contents($savesFile, json_encode($saves, JSON_PRETTY_PRINT)) === false) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Could not write saves file']);
        exit;
    }

    // Répondre avec succès
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>
