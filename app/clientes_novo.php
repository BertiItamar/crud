<?php

use LDAP\Result;

require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $nome = $_POST['text_nome'];
    $email = $_POST['text_email'];
    $telefone = $_POST['text_telefone'];

    $results = api_request('create_new_client', 'POST', [
        'nome' => $nome,
        'email' => $email,
        'telefone' => $telefone
    ]);
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

    <div class="row my-5">

    <form action="clientes_novo.php" method="POST">

        <div class="col-sm-6 offset-sm-3 card bg-ligth p-4">
            <div class="mb-3">
                <label>Nome do cliente:</label>
                <input type="text" name="text_nome" class="form-control">
            </div>

            <div class="mb-3">
                <label>Telefone:</label>
                <input type="text" name="text_telefone" class="form-control">
            </div>

            <div class="mb-3">
                <label>E-mail:</label>
                <input type="text" name="text_email" class="form-control">
            </div>

            <div class="mb-3 text-center">
                <input type="submit" value="Save" class="btn btn-primary">
                <a href="clientes.php" class="btn btn-dark">Cancel</a>
            </div>
        </div>

    </form>
    </div>

    <script>
        src = "../assets/bootstrap/bootstrap.bundle.min.js"
    </script>
</body>

</html>