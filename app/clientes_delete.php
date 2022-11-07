<?php

require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');


if(!isset($_GET['id'])){
    header("location: clientes.php");
    exit;
}

if(isset($_GET['confirm']) && $_GET['confirm'] == 'true'){
    api_request('delete_client', 'GET', ['id' => $_GET['id']]);
    header("location: clientes.php");
    exit;
}

$results = api_request('get_client', 'GET', ['id' => $_GET['id']]);


if((count($results['data']['result'])) == 0){
    header("location: clientes.php");
    exit;
}

if ($results['data']['status'] == 'Success') {
    $clientes = $results['data']['result'][0];
} else {
    $clientes = [];
}

if(empty($clientes)){
    header("location: clientes.php");
    exit;
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

                <h5 class="text-center">
                    Deseja eliminar o cliente <strong><?= $clientes['nome'] ?></strong>
                </h5>

                <div class="text-center mt-3">
                    <a href="clientes.php" class="btn btn-secondary"> Não</a>
                    <a href="clientes_delete.php?id=<?= $clientes['id_cliente'] ?>&confirm=true" class="btn btn-primary"> Sim</a>
                </div>
            </div>
        </div>
    </section>

    <script>
        src = "../assets/bootstrap/bootstrap.bundle.min.js"
    </script>
</body>

</html>