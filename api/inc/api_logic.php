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

    public function status(){
        return[
            'status' => 'SUCCESS',
            'message' => 'API is running Ok!'
        ];
    }

    public function get_all_client(){
        //query to the database
        return[
            'status' => 'Success',
            'message' => '',
            'result' => [
                'joao', 'ana', 'pedro', 'antonio'
            ]
        ];
    }

    public function get_all_products(){
        
    }
}