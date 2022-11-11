<?php

class api_logic{
    private $endpoint;
    private $params;


    public function __construct($endpoint, $params = null)
    {
        $this->endpoint = $endpoint;
        $this->params = $params;
    }

    public function endpoint_exists(){
        return method_exists($this, $this->endpoint);
    }

    public function error_response($message){
        return[
            'status' => 'Error',
            'message' => $message,
            'result' => []
        ];       
    }

    public function status(){
        return[
            'status' => 'SUCCESS',
            'message' => 'API is running Ok!'
        ];
    }

    
    public function get_all_active_client(){
        //query to the database
        $sql = "SELECT * FROM clientes WHERE deleted_at IS NULL";

        $db = new database();
        $results = $db->EXE_QUERY($sql);

        return[
            'status' => 'Success',
            'message' => '',
            'result' => $results
        ];
    }

    public function get_all_inactive_client(){
        //query to the database
        $sql = "SELECT * FROM clientes WHERE deleted_at IS NOT NULL";

        $db = new database();
        $results = $db->EXE_QUERY($sql);

        return[
            'status' => 'Success',
            'message' => '',
            'result' => $results
        ];
    }

    public function get_client(){
        //query to the database
        $sql = "SELECT * FROM clientes WHERE 1 ";

        if(key_exists('id', $this->params)){

            if(filter_var($this->params['id'], FILTER_VALIDATE_INT)){
                $sql .= "AND id_cliente = ". intval($this->params['id']);
            }
        }else{

            return $this->error_response('ID cliente not specified');                  
        }

        $db = new database();
        $results = $db->EXE_QUERY($sql);

        return[
            'status' => 'Success',
            'message' => '',
            'result' => $results
        ];
    }

    public function get_all_client(){
        //query to the database
        $sql = "SELECT * FROM clientes";

        $db = new database();
        $results = $db->EXE_QUERY($sql);

        return[
            'status' => 'Success',
            'message' => '',
            'result' => $results
        ];
    }

    //===================================================================================

    public function get_all_products(){

        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM produtos");

        return[
            'status' => 'Success',
            'message' => '',
            'result' => $results
        ];
    }

    public function get_all_active_products(){
        //query to the database

        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM produtos WHERE deleted_at IS NULL");

        return[
            'status' => 'Success',
            'message' => '',
            'result' => $results
        ];
    }

    public function get_all_inactive_products(){
        //query to the database

        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM produtos WHERE deleted_at IS NOT NULL");

        return[
            'status' => 'Success',
            'message' => '',
            'result' => $results
        ];
    }

    public function get_all_products_without_stock(){
        //query to the database

        $db = new database();
        $results = $db->EXE_QUERY("SELECT * FROM produtos WHERE quantidade <= 0 AND deleted_at IS NULL");

        return[
            'status' => 'Success',
            'message' => '',
            'result' => $results
        ];
    }

    public function create_new_client(){
        if(
            !isset($this->params['nome']) ||
            !isset($this->params['email']) ||
            !isset($this->params['telefone'])
        ){
            return $this->error_response('Insuficent client data.');
        }

        $db = new database();
        $params = [
            ':nome' => $this->params['nome'],
            ':email' => $this->params['email'],
        ];
        $results = $db->EXE_QUERY("
            SELECT id_cliente FROM clientes
            WHERE nome = :nome OR email = :email  
        ", $params);

        if(count($results) != 0){
            return $this->error_response('There is another client with the same name or email.');
        }

        $params = [
            ':nome' => $this->params['nome'],
            ':email' => $this->params['email'],
            ':telefone' => $this->params['telefone'],
        ];

        $db->EXE_QUERY("
            INSERT INTO clientes VALUES(
                0,
                :nome,
                :email,
                :telefone,
                NOW(),
                NOW(),
                NULL
            )
        ", $params);

        return[
            'status' => 'Success',
            'message' => 'Novo cliente adicionado.',
            'result' => []
        ];
    }

    public function create_new_product(){
        if(
            !isset($this->params['produtos']) ||
            !isset($this->params['quantidade']) 
        ){
            return $this->error_response('Insuficent product data.');
        }

        $db = new database();
        $params = [
            ':produtos' => $this->params['produtos'],
        ];
        $results = $db->EXE_QUERY("
            SELECT id_produtos FROM produtos
            WHERE produtos = :produtos 
        ", $params);

        if(count($results) != 0){
            return $this->error_response('There is another product with the same name.');
        }

        $params = [
            ':produtos' => $this->params['produtos'],
            ':quantidade' => $this->params['quantidade'],
        ];

        $db->EXE_QUERY("
            INSERT INTO produtos VALUES(
                0,
                :produtos,
                :quantidade,
                NOW(),
                NOW(),
                NULL
            )
        ", $params);

        return[
            'status' => 'Success',
            'message' => 'Novo produto adicionado.',
            'result' => []
        ];
    }

    public function delete_client(){
        if(
            !isset($this->params['id'])
        ){
            return $this->error_response('Insuficent client data.');
        }

        $db = new database();
        $params = [
            ':id_cliente' => $this->params['id']
        ];

        $db->EXE_NON_QUERY("UPDATE clientes SET deleted_at = NOW() WHERE id_cliente = :id_cliente", $params);

        return[
            'status' => 'Success',
            'message' => 'Cliente deletado com sucesso.',
            'result' => []
        ];
    }

    public function create_new_addess(){
        if(
            !isset($this->params['rua']) ||
            !isset($this->params['cidade']) ||
            !isset($this->params['estado']) ||
            !isset($this->params['cep'])
        ){
            return $this->error_response('Insuficent product data.');
        }

        $db = new database();
        $params = [
            ':endereco_clientes' => $this->params['endereco_clientes'],
        ];
        $results = $db->EXE_QUERY("
            SELECT id_endereco_clientes FROM endereco_clientes
            WHERE endereco_clientes = :endereco_clientes 
        ", $params);

        if(count($results) != 0){
            return $this->error_response('There is another product with the same name.');
        }

        $params = [
            'rua' => $this->params['rua'],
            ':cidade' => $this->params['cidade'],
            ':estado' => $this->params['estado'],
            ':cep' => $this->params['cep']     
        ];

        $db->EXE_QUERY("
            INSERT INTO endereco_clientes VALUES(
                0,
                :rua,
                :cidade,
                estado,
                cep,
                NOW(),
                NOW(),
                NULL
            )
        ", $params);

        return[
            'status' => 'Success',
            'message' => 'New adress add.',
            'result' => []
        ];
    }
}