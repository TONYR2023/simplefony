<?php

namespace Mvc\Framework\App\Controller;
use Mvc\Framework\Kernel\AbstractController;
use Mvc\Framework\Kernel\Attributes\Endpoint;

class ProduitController extends AbstractController
{
    #[Endpoint('/products/create', name:'create_products', requestMethod: 'POST' )]
    public function create(){
        $this->send([
            "message" => "endpoint pour la création"
        ]);
    }

    #[Endpoint('/products/read', name:'read_products', requestMethod: 'GET' )]
    public function read(){
        $this->send([
            "message" => "endpoint pour la lecture"
        ]);
    }

    #[Endpoint('/products/delete', name:'delete_products', requestMethod: 'GET' )]
    public function delete(){
        $this->send([
            "message" => "endpoint pour la supprimer"
        ]);
    }
    
    #[Endpoint('/products/update', name:'update_products', requestMethod: 'PATCH' )]
    public function update(){
        $this->send([
            "message" => "endpoint pour la modification"
        ]);
    }
}
