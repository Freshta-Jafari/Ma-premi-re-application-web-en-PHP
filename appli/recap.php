<?php
session_start();
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
    <h1>Récapitulatif des Produits</h1>

    <?php if (isset($_SESSION['produits']) && count($_SESSION['produits']) > 0): ?>
        <table border="1">
            <tr>
                <th>Nom</th>
                <th>Prix Unitaire</th>
                <th>Quantité</th>
                <th>Total prix</th>
            </tr>
            <?php
            $totalGeneral = 0;
            foreach ($_SESSION['produits'] as $produit):
                $totalGeneral += $produit['total'];
            ?>
            <tr>
                <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                <td><?php echo number_format($produit['prix'], 2, ',', ' '); ?> €</td>
                <td><?php echo $produit['quantite']; ?></td>
                <td><?php echo number_format($produit['total'], 2, ',', ' '); ?> €</td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h2>Total Général : <?php echo number_format($totalGeneral, 2, ',', ' '); ?> €</h2>
    <?php else: ?>
        <p>Aucun produit ajouté.</p>
    <?php endif; ?>

    <a href="index.php">Ajouter un autre produit</a>
</body>
</html>
