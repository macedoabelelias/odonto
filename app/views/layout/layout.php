<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel - Odonto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body>

<div class="d-flex">

    <?php require BASE_PATH . "/app/views/layout/sidebar.php"; ?>

    <div class="flex-grow-1">

        <?php require BASE_PATH . "/app/views/layout/navbar.php"; ?>

        <div class="container-fluid mt-4">
            <?php require $viewFile; ?>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>