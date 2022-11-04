<?php


require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');

$results = api_request('get_all_products', 'GET');

if ($results['data']['status'] == 'Success') {
    $produtos = $results['data']['result'];
} else {
    $produtos = [];
}

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Consumidora - Produtos</title>
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>

<body class="bg-dark text-white">
    <?php include('inc/nav.php') ?>
    <section class="container">
        <div class="row">
            <div class="col">

                <div class="row">
                    <div class="col">
                        <h1>Produtos</h1>
                    </div>
                    <div class="col text-end align-self-center">
                        <a href="produtos_novo.php" class="btn btn-primary btn-sm" >Adicionar Produtos...</a>
                        
                    </div>
                </div>
                

                <hr>

                <?php if (count($produtos) == 0) : ?>
                    <p class="text-center"> Não existem produtos registrados.</p>
                <?php else : ?>
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                <?php endif; ?>

                    <tbody>
                        <?php foreach ($produtos as $produto) : ?>
                            <tr>
                                <td><?= $produto['produtos'] ?></td>
                                <td><?= $produto['quantidade'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p>Total: <strong><?= count($produtos) ?></strong></p>
            </div>
        </div>
    </section>

    <script>
        src = "../assets/bootstrap/bootstrap.bundle.min.js"
    </script>
</body>

</html>