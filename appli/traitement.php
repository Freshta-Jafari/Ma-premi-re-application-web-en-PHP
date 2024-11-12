<?php
// Vérifier si la session n'est pas encore démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire et sécuriser les entrées
    $nom = htmlspecialchars($_POST['nom']);
    $prix = htmlspecialchars($_POST['prix']);
    $quantite = htmlspecialchars($_POST['quantite']);

    // Vérification de la validité des données
    if (empty($nom) || $prix <= 0 || $quantite <= 0) {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Veuillez remplir correctement tous les champs.'
        ];
        header("Location: index.php");
        exit();
    }

    // Calculer le total
    $total = $prix * $quantite;

    // Créer un tableau produit
    $produit = [
        'nom' => $nom,
        'prix' => $prix,
        'quantite' => $quantite,
        'total' => $total
    ];

    // Initialiser la session si elle n'existe pas
    if (!isset($_SESSION['produits'])) {
        $_SESSION['produits'] = [];
    }

    // Ajouter le produit à la session
    $_SESSION['produits'][] = $produit;

    // Ajouter un message de succès
    $_SESSION['message'] = [
        'type' => 'success',
        'text' => 'Produit ajouté avec succès.'
    ];

    // Rediriger vers la page de récapitulatif
    header("Location: recap.php");
    exit();
}

function getTotalItemsInCart() {
    $totalItems = 0;

    // Vérifier si les produits sont dans la session
    if (isset($_SESSION['produits']) && is_array($_SESSION['produits'])) {
        foreach ($_SESSION['produits'] as $product) {
            $totalItems += $product['quantite'];
        }
    }

    return $totalItems;
}
