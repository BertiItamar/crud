<?php

require_once('inc/config.php');
require_once('inc/api_functions.php');

$variables = [
    'nome' => 'joao',
    'apelido' => 'ribeiro'
];

$result = api_request('status', 'GET', $variables);


echo '<pre>';
print_r($result);
$result = api_request('get_all_client', 'GET', $variables);
print_r($result);