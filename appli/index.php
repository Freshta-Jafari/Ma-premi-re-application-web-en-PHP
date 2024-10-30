<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ajouter produit</title>
</head>
<body>
    <h1>Ajouter un produit</h1>
    <form action="traitement.php" method="post">
        <label for="nom">Nom du produit : </label>
        <input type="text" name="nom" id="nom" required><br>

        <label for="prix">Prix du produit :</label>
        <input type="number" name="prix" id="prix" step="0.01" required><br>

        <label for="quantite">Quantité désirée :</label>
        <input type="number" name="quantite" id="quantite" required><br>

        <button type="submit">Ajouter</button>
    </form>
    <a href="recap.php">Voir le récapitulatif</a>
  
</body>
</html>