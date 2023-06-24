<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/style.css">
    <title><?php echo isset($message) ? $message : "Title"; ?></title>
</head>

<body>
    <div class="container">
        <?php echo isset($message) ? $message : null; ?>
        <?php echo isset($erreur) ? $erreur : null; ?>
        <?php echo isset($erreur) ? "<div class=\"erreur\">$erreur</div>" : null; ?>
        <?php echo isset($content) ? $content : null; ?>
    </div>
    <script src="../dist/app-bundle.js"></script>
</body>

</html>