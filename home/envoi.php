<?php
// Vérifier si les données du formulaire sont envoyées
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = $_POST['nom'];

    // URL de l'API Airtable (remplacez par l'ID de votre base et le nom de la table)
    $api_url = 'https://api.airtable.com/v0/appPolKC7kkfQvMQj/ETUDIANT';

    // Votre clé API Airtable (remplacez par votre propre clé)
    $api_key = 'patJgBGlZNjyf2D5q.d9f8df480c3c9f27d4565549b14830bc2d1a30b92a74d6a0766d6f60f53dc6e7';

    // Préparation des données à envoyer à Airtable
    $data = [
        'fields' => [
            'Name' => $name,
          
        ]
    ];

    // Encodage en JSON
    $json_data = json_encode($data);

    // Initialisation de la requête cURL
    $ch = curl_init($api_url);

    // Configuration de la requête cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: $api_key",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

    // Exécution de la requête
    $response = curl_exec($ch);

    // Vérification des erreurs
    if (curl_errno($ch)) {
        echo 'Erreur cURL : ' . curl_error($ch);
    } else {
        // Afficher la réponse d'Airtable
        $response_data = json_decode($response, true);
        if (isset($response_data['id'])) {
            echo 'Données envoyées avec succès à Airtable (ID : ' . $response_data['id'] . ')';
        } else {
            echo 'Erreur lors de l\'envoi des données à Airtable : ' . $response;
        }
    }

    // Fermeture de la session cURL
    curl_close($ch);
} else {
    echo 'Erreur : méthode de requête non supportée.';
}
