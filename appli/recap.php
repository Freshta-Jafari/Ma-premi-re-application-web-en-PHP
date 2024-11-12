<?php
session_start();
include 'traitement.php';

// Supprimer un produit
if (isset($_GET['delete']) && isset($_SESSION['produits'][$_GET['delete']])) {
    unset($_SESSION['produits'][$_GET['delete']]);
    $_SESSION['message'] = [
        'type' => 'success',
        'text' => 'Produit supprimé avec succès.'
    ];
    header("Location: recap.php");
    exit();
}

// Supprimer tous les produits
if (isset($_POST['delete_all'])) {
    $_SESSION['produits'] = [];
    $_SESSION['message'] = [
        'type' => 'success',
        'text' => 'Tous les produits ont été supprimés.'
    ];
    header("Location: recap.php");
    exit();
}

// Modifier la quantité
if (isset($_POST['update'])) {
    $index = $_POST['index'];
    $new_quantity = $_POST['new_quantity'];
    
    if ($new_quantity > 0) {
        $_SESSION['produits'][$index]['quantite'] = $new_quantity;
        $_SESSION['produits'][$index]['total'] = $_SESSION['produits'][$index]['prix'] * $new_quantity;
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'Quantité mise à jour.'
        ];
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'La quantité doit être positive.'
        ];
    }
    header("Location: recap.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Récapitulatif des Produits</title>
</head>
<body>
<header>
    <nav>
        <a href="index.php">Page d'Accueil</a>
        <a href="recap.php">Récapitulatif</a>
    </nav>
    <div class="cart-info">
        Nombre total d'articles : <?php echo getTotalItemsInCart(); ?>
    </div>
</header>

<h1>Récapitulatif des Produits</h1>

<?php if (isset($_SESSION['message'])): ?>
    <div class="message <?php echo $_SESSION['message']['type']; ?>">
        <?php echo $_SESSION['message']['text']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['produits']) && count($_SESSION['produits']) > 0): ?>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Prix Unitaire</th>
            <th>Quantité</th>
            <th>Total prix</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($_SESSION['produits'] as $index => $produit): ?>
        <tr>
            <td><?php echo htmlspecialchars($produit['nom']); ?></td>
            <td><?php echo number_format($produit['prix'], 2, ',', ' '); ?> €</td>
            <td>
                <form method="post" style="display:inline;">
                    <button type="submit" name="update" value="true">-</button>
                    <input type="number" name="new_quantity" value="<?php echo $produit['quantite']; ?>" style="width:50px;">
                    <button type="submit" name="update" value="true">+</button>
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                </form>
            </td>
            <td><?php echo number_format($produit['total'], 2, ',', ' '); ?> €</td>
            <td>
                <a href="?delete=<?php echo $index; ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h2>Total Général : <?php echo number_format(array_sum(array_column($_SESSION['produits'], 'total')), 2, ',', ' '); ?> €</h2>

    <form method="post">
        <button type="submit" name="delete_all">Supprimer tous les produits</button>
    </form>

<?php else: ?>
    <p>Aucun produit ajouté.</p>
<?php endif; ?>

</body>
</html>
