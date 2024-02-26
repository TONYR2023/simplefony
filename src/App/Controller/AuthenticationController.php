<?php

namespace Mvc\Framework\App\Controller;

use Mvc\Framework\Kernel\AbstractController;
use Mvc\Framework\Kernel\Attributes\Endpoint;
use Mvc\Framework\App\Entity\Utilisateur;
use Mvc\Framework\App\Repository\UtilisateurRepository;
use Mvc\Framework\Kernel\JwtManager;
use Mvc\Framework\Kernel\Utils\Request;
use Mvc\Framework\Kernel\Utils\Serializer;

class AuthenticationController extends AbstractController
{
    #[Endpoint(
        path :'/authentication/create/account',
        name:'create_account',
        requestMethod: 'POST',
        protected : true
        )]
    public function create(Serializer $serializer, Request $request, UtilisateurRepository $utilisateurRepository)
    {
        // j'intencie une nouvelle entité de type x
        $utilisateur = new Utilisateur;
        // j'utilise 
        $utilisateur->setNom($request->retrievePostValue('nom'));
        $utilisateur->setPrenom($request->retrievePostValue('prenom'));
        $utilisateur->setEmail($request->retrievePostValue('email'));
        $utilisateur->setMdp(password_hash($request->retrievePostValue('mdp'), PASSWORD_BCRYPT));
        $utilisateur->setRoles($request->retrievePostValue('roles'));

        $utilisateurRepository->save($utilisateur);

        $serializedUtilisateur = $serializer->serialize($utilisateur);
      
        $token = JwtManager::generateToken($serializedUtilisateur);
        $tokendecode = JwtManager::decodeToken($token);
        $this->send(
            ["utilisateur" => $serializedUtilisateur]
        );
    }

    #[Endpoint(
        path :'/authentication/show/myaccount',
        name:'show_account', 
        requestMethod: 'GET' 
        )]
    public function show(){
        $this->send([
            "message" => "endpoint pour la lecture"
        ]);
    }

    #[Endpoint(
        path:'/authentication/delete/myaccount', 
        name:'delete_account', 
        requestMethod: 'GET' 
        )]
    public function delete(){
        $this->send([
            "message" => "endpoint pour la supprimer"
        ]);
    }
    
    #[Endpoint(
        path:'/authentication/update/myaccount', 
        name:'update_account', 
        requestMethod: 'PATCH' 
        )]
    public function update(){
        $this->send([
            "message" => "endpoint pour la modification"
        ]);
    }

    #[Endpoint(path:'/authentication/login',
     name: 'login_account', requestMethod: 'POST' )]
    public function login(Request $request, UtilisateurRepository $utilisateurRepository)
    {
        //on recupere et on stocke le user en db
        $user = $utilisateurRepository->findBy([
            "email" => $request->retrievePostValue("email")
        ]);
       //on cible l'index 0 pour recuperer le user car c'est dans tableau indexé
        $userFound = $user[0];
        //on recupere le mdp recu du client 
        $clientPassword = $request->retrievePostValue("mdp");
        //on recupere le mot de passe hashé de l'utilisateur
        $hashedPassword = $userFound["mdp"];
        //verification du password
        if (password_verify($clientPassword,$hashedPassword))
        {
        //ici on doit generer le token
        //le token doit contenir les informations utiles pour retrouver quel
        // utilisateur se connecte à notre api
        //creation d'un tableau pour avoir les infos que l'on desire utiliser
        //puis l'on genere le token d'autentification 
            $data = [
                "id" => $userFound["id"],
                "email" => $userFound["email"],
                "roles" => $userFound["roles"],
            ];
           $token = JwtManager::generateToken($data);
            $this->send(["message" => 'vous etes bien connecte',
            "token" => $token
            ]);
        } else {
        // sinon on envoi une erreur
            $this->send(['le mots de passe ou l\'email est incorrect']);
        }
        

    
    }
}