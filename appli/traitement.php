
<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Récupérer les données du formulaire
     $nom = $_POST['nom'];
     $prix = $_POST['prix'];
     $quantite = $_POST['quantite'];

    // Calculer le total
    $total = $prix * $quantite;

    // Créer un tableau produit
    $produit = [
        'nom'=> $nom,
        'prix'=> $prix,
        'quantite'=> $quantite,
        'total'=> $total
    ];
    // Initialiser la session si elle n'existe pas
    if (isset($_SESSION['produits'])){
        $_SESSION['produits'] = [];
    }
    // Ajouter le produit à la session
    $_SESSION['produits'][] = $produit;
    // Rediriger vers la page de récapitulatif
    header("Location: recap.php");
    exit();

} 

