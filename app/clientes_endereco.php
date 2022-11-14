<?php

use App\Webservice\ViaCep;
use LDAP\Result;

require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');


function consultarCEP($cep){
        
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://viacep.com.br/ws/'.$cep .'/json/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'GET'
    ]);

    $response = curl_exec($curl);
    
    curl_close($curl);

    $array = json_decode($response, true);

    return isset($array['cep']) ? $array : null;        
};


if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    if (!isset($_GET['id'])) {

        header("Location: clientes.php");
    }

    // $cliente = api_request('get_client', 'POST', ['id' => $_GET['id']])['data']['results'][0];
}

//===============================================//

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clientes = $_POST['id_cliente'];
    $rua = $_POST['text_rua'];
    $cidade = $_POST['text_cidade'];
    $estado = $_POST['text_estado'];
    $cep = $_POST['text_cep'];

    $results = api_request('create_new_address', 'POST', [
        'id_cliente' => $clientes,
        'rua' => $rua,
        'cidade' => $cidade,
        'estado' => $estado,
        'cep' => $cep
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
    <title>Novo cliente</title>
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/clientes_novo.css">

</head>

<body class="bg-dark">

    <?php include('inc/nav.php') ?>

    <section class="container">
        <div class="row my-5">
            <div class="col-sm-6 offset-sm-3 card bg-light p-4">
                <form action="clientes_endereco.php" method="POST">
                    <div>
                        <input type="hidden" name="id_cliente" value="<?= $clientes['id_cliente'] ?>">
                    </div>
                    <div class="mb-3">
                        <label>Rua</label>
                        <input type="text" name="text_rua" class="form-control" value="<?= $array['logradouro'] ?>">
                    </div>
                    <br>
                    <div class="mb-3">
                        <label>Cidade</label>
                        <input type="text" name="text_cidade" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Estado</label>
                        <input type="text" name="text_estado" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>CEP</label>
                        <input type="text" name="text_cep" class="form-control">
                    </div>
                    <br>
                    <div class="mb-3 text-center">
                        <a href="clientes.php" class="btn btn-secondary btn-lg">Cancelar</a>
                        <input type="submit" value="Salvar" class="btn btn-primary btn-lg">
                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger p-2 text-center">
                                <?= $error_message ?>
                            </div>
                        <?php elseif (!empty($success_message)) : ?>
                            <div class="alert alert-success p-2 text-center">
                                <?= $success_message ?>
                            </div>
                        <?php endif; ?>
                    </div>
            </div>
        </div>
        </form>
        </div>

        <script>
            src = "../assets/bootstrap/bootstrap.bundle.min.js"
        </script>
</body>

</html>