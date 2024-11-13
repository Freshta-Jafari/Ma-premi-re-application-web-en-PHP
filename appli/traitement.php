<?php
session_start();

// Vérifier si l'action est définie
if (isset($_GET['action'])) {
    switch ($_GET['action']) {

        // Cas pour ajouter un produit
        case "add":
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nom'], $_POST['prix'], $_POST['quantite'])) {

                // Récupérer les données du formulaire et sécuriser les entrées
                $nom = htmlspecialchars(trim($_POST['nom']));
                $prix = floatval($_POST['prix']);
                $quantite = intval($_POST['quantite']);

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

                // Message de succès
                $_SESSION['message'] = [
                    'type' => 'success',
                    'text' => 'Produit ajouté avec succès.'
                ];
              
                // Rediriger vers la page de récapitulatif
                header("Location: recap.php");
                exit();
            }
            break;

        // Cas pour supprimer un produit
        case "delete":
            if (isset($_GET['delete']) && isset($_SESSION['produits'][$_GET['delete']])) {
                unset($_SESSION['produits'][$_GET['delete']]);
                $_SESSION['message'] = [
                    'type' => 'success',
                    'text' => 'Produit supprimé avec succès.'
                ];
                header("Location: recap.php");
                exit();
            }
            break;

        // Cas pour supprimer tous les produits
        case "clear":
            if (isset($_POST['delete_all'])) {
                $_SESSION['produits'] = [];
                $_SESSION['message'] = [
                    'type' => 'success',
                    'text' => 'Tous les produits ont été supprimés.'
                ];
                header("Location: recap.php");
                exit();
            }
            break;

        // Cas pour augmenter la quantité d'un produit
        case "increase-quantite":
            if (isset($_POST['index']) && isset($_SESSION['produits'][$_POST['index']])) {
                $index = $_POST['index'];
                $_SESSION['produits'][$index]['quantite']++;
                $_SESSION['produits'][$index]['total'] = $_SESSION['produits'][$index]['quantite'] * $_SESSION['produits'][$index]['prix'];

                $_SESSION['message'] = [
                    'type' => 'success',
                    'text' => 'Quantité augmentée.'
                ];

                header("Location: recap.php");
                exit();
            }
            break;

        // Cas pour diminuer la quantité d'un produit
        case "decrease-quantite":
            if (isset($_POST['index']) && isset($_SESSION['produits'][$_POST['index']])) {
                $index = $_POST['index'];
                if ($_SESSION['produits'][$index]['quantite'] > 1) {
                    $_SESSION['produits'][$index]['quantite']--;
                    $_SESSION['produits'][$index]['total'] = $_SESSION['produits'][$index]['quantite'] * $_SESSION['produits'][$index]['prix'];

                    $_SESSION['message'] = [
                        'type' => 'success',
                        'text' => 'Quantité réduite.'
                    ];
                } else {
                    $_SESSION['message'] = [
                        'type' => 'error',
                        'text' => 'La quantité ne peut pas être inférieure à 1.'
                    ];
                }

                header("Location: recap.php");
                exit();
            }
            break;

        // Ajouter un autre cas "default" pour gérer des actions invalides
        default:
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Action invalide.'
            ];
            header("Location: recap.php");
            exit();
    }
}
// Fonction pour obtenir le nombre total d'articles
function getTotalItems() {
    $totalItems = 0;
    if (isset($_SESSION['produits']) && is_array($_SESSION['produits'])) {
        foreach ($_SESSION['produits'] as $produit) {
            $totalItems += $produit['quantite'];
        }
    }
    return $totalItems;
}
