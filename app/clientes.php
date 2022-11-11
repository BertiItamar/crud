<?php

require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');

$results = api_request('get_all_active_client', 'GET');

if ($results['data']['status'] == 'Success') {
    $clientes = $results['data']['result'];
} else {
    $clientes = [];
}

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Consumidora - Clientes</title>
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>

<body class="bg-dark text-white">

    <?php include('inc/nav.php') ?>
    <section class="container">
        <div class="row">
            <div class="col">

            
            <div class="row">
                    <div class="col">
                        <h1>Clientes</h1>
                    </div>
                    <div class="col text-end align-self-center">
                        <a href="clientes_novo.php" class="btn btn-primary btn-sm" >Adicionar cliente...</a>
                        
                    </div>
                </div>

                <hr>

                    <?php if (count($clientes) == 0) : ?>
                        <p class="text-center"> Não existem clientes registrados.</p>
                    <?php else : ?>
                    <table class="table table-dark table-hover">
                        <thead class="table-dark">
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th></th>
                        </thead>

                        <?php endif; ?>

                        <tbody>
                            <?php foreach ($clientes as $cliente) : ?>
                                <tr>
                                    <td><?= $cliente['nome'] ?></td>
                                    <td><?= $cliente['email'] ?></td>
                                    <td><?= $cliente['telefone'] ?></td>
                                    <td>
                                        <a class="btn btn-danger" href="clientes_delete.php?id=<?= $cliente['id_cliente'] ?> ">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p>Total: <strong><?= count($clientes) ?></strong></p>
            </div>
        </div>
    </section>

    <script>
        src = "../assets/bootstrap/bootstrap.bundle.min.js"
    </script>
</body>

</html>