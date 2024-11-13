<?php
// session_start();

include 'traitement.php';

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
            <!-- Separate form for the decrease button -->
            <form action="traitement.php?action=decrease-quantite" method="post" style="display:inline;">
                <button type="submit" name="update" value="decrease">-</button>
                <input type="hidden" name="index" value="<?php echo $index; ?>">
            </form>

            <!-- Input field for the current quantity -->
            <input type="number" name="new_quantity" value="<?php echo $produit['quantite']; ?>" style="width:50px;" min="1" readonly />

            <!-- Separate form for the increase button -->
            <form action="traitement.php?action=increase-quantite" method="post" style="display:inline;">
                <button type="submit" name="update" value="increase">+</button>
                <input type="hidden" name="index" value="<?php echo $index; ?>">
            </form>
        </td>
            <td><?php echo number_format($produit['total'], 2, ',', ' '); ?> €</td>
            <td>
                <a href="?action=delete&delete=<?php echo $index; ?>">Supprimer</a><br>
                <!-- <a href="index.php">Ajouter un nouvel article</a> -->
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="cart-info">
    
        <h4>Nombre total de tous les articles : <?php echo getTotalItems(); ?></h4> 
        <h3>Prix ​​total de tous les articles : <?php echo number_format(array_sum(array_column($_SESSION['produits'], 'total')), 2, ',', ' '); ?> €</h3>
    </div>


    <form action="traitement.php?action=clear" method="post" id="delete">
        <button type="submit" name="delete_all" class="delete_produits">Supprimer tous les produits</button>
    </form>

<?php else: ?>
    <p>Aucun produit ajouté.</p>
<?php endif; ?>

</body>
</html>
