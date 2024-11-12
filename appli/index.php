<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ajouter un produit</title>
</head>
<body>
<header>
    <nav>
        <a href="index.php">Page d'Accueil</a>
        <a href="recap.php">Récapitulatif</a>
    </nav>
</header>

<h1>Ajouter un produit</h1>

<?php if (isset($_SESSION['message'])): ?>
    <div class="message <?php echo $_SESSION['message']['type']; ?>">
        <?php echo $_SESSION['message']['text']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<form action="traitement.php" method="post">
    <label for="nom">Nom du produit : </label>
    <input type="text" name="nom" id="nom" required><br>

    <label for="prix">Prix du produit :</label>
    <input type="number" name="prix" id="prix" step="0.01" required><br>

    <label for="quantite">Quantité désirée :</label>
    <input type="number" name="quantite" id="quantite" required><br>

    <button type="submit">Ajouter</button>
</form>

</body>
</html>
