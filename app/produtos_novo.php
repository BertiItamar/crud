<?php

use LDAP\Result;

require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $produto = $_POST['text_produtos'];
    $quantidade = $_POST['text_quantidade'];

    $results = api_request('create_new_product', 'POST', [
        'produtos' => $produto,
        'quantidade' => $quantidade,
    ]);

    if ($results['data']['status'] == 'Error') {
        $error_message = $results['data']['message'];
    } elseif ($results['data']['status'] == 'Success') {
        $success_message = $results['data']['message'];
    }
}


?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Consumidora - Novo cliente</title>
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>

<body class="bg-dark">

    <?php include('inc/nav.php') ?>

    <div class="row my-5 mx-auto">


        <div class="col-sm-6 offset-sm-3 card bg-ligth p-4">
            <form action="produtos_novo.php" method="POST">
                <div class="mb-3">
                    <label>Nome do produto:</label>
                    <input type="text" name="text_produto" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Quantidade:</label>
                    <input type="number" name="number_quantidade" class="form-control">
                </div>

                <div class="mb-3 text-center">
                    <input type="submit" value="Save" class="btn btn-primary">
                    <a href="produtos.php" class="btn btn-dark">Cancel</a>
                </div>

                <?php if (!empty($error_message)) : ?>

                    <div class="alert alert-danger p-2 text-center">
                        <?= $error_message ?>
                    </div>

                <?php elseif (!empty($success_message)) : ?>

                    <div class="alert alert-success p-2 text-center">
                        <?= $success_message ?>
                    </div>

                <?php endif; ?>
            </form>
        </div>

    </div>

    <script>
        src = "../assets/bootstrap/bootstrap.bundle.min.js"
    </script>
</body>

</html>