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
                    
                        unset($_SESSION['produits'][$index]);
                        $_SESSION['message'] = [
                            'type' => 'success',
                            'text' => 'Produit supprimé avec succès.'
                        ];
                        header("Location: recap.php");
                        exit();
                    
                    // $_SESSION['message'] = [
                    //     'type' => 'error',
                    //     'text' => 'La quantité ne peut pas être inférieure à 1.'
                    // ];
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

//  session :  
// A session in PHP is a way to store different data for each user using a unique session identifier.
// Session identifiers will usually be sent to the browser via session cookies and will be used to retrieve existing session data.
// One of the great advantages of sessions is that we will be able to keep information for a user when he navigates from one page to another.
// In addition, session information will not be stored on your visitors' computers unlike cookies but rather on the server side which means that
// sessions will be much more secure than cookies. Note however that the purpose of sessions is not to keep information indefinitely but simply during a "session". 
// A session starts as soon as the session_start() function is called and generally ends as soon as the current browser window is closed
// (unless a function is called to end the session early or a session cookie with a longer lifespan has been defined).
// The $_SESSION superglobal is an associative array that will hold all session data once the session is started.




// super globale : some predifined vaiables that they are always accessible , regradless scope and
// we can access them from any function, class 
// thses varaibles will all be array that will contain groupes of very differentes varaibles
// they are 9 :
// $GLOBALS : The $GLOBALS is an assosiatif array variable that automatically stores all the global variables declared in the script.
// $_SERVER :   The $_SERVER superglobal contains variables defined by the server used as well as information related to the script.
// $_REQUEST  :  This variable, which is an associative array, will thus contain the variables $_GET, $_POST and $_COOKIE.
// $_GET :   $_GET will store the values ​​when the form is sent via the GET method.
// $_POST :  $_POST will store the values ​​when the form is sent via the POST method.
// $_FILES :   The $_FILES superglobal will contain information about an uploaded file, such as the file type, size, name, etc.
// $_COOKIE  :  The $_COOKIE superglobal is an associative array that contains all variables passed via HTTP cookies.
// $_SESSION   :  The $_SESSION superglobal is an associative array that contains all session variables.
// $_ENV  :  The $_ENV superglobal will contain information related to the environment in which the script is running.
