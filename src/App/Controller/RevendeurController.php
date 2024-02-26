<?php

namespace Mvc\Framework\App\Controller;
use Mvc\Framework\Kernel\AbstractController;
use Mvc\Framework\Kernel\Attributes\Endpoint;

class RevendeurController extends AbstractController
{
    #[Endpoint('/reseller/create', name:'create_reseller', requestMethod: 'POST' )]
    public function create(){
        $this->send([
            "message" => "endpoint pour la création"
        ]);
    }

    #[Endpoint('/reseller/show', name:'show_reseller', requestMethod: 'GET' )]
    public function show(){
        $this->send([
            "message" => "endpoint pour la lecture"
        ]);
    }

    #[Endpoint('/reseller/delete', name:'delete_reseller', requestMethod: 'GET' )]
    public function delete(){
        $this->send([
            "message" => "endpoint pour la supprimer"
        ]);
    }
    
    #[Endpoint('/reseller/update', name:'update_reseller', requestMethod: 'PATCH' )]
    public function update(){
        $this->send([
            "message" => "endpoint pour la modification"
        ]);
    }
}