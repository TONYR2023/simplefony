<?php
namespace Mvc\Framework\Kernel;

use Mvc\Framework\App\Repository\UtilisateurRepository;


class Guard {
    public static function check(): bool
    {
        try{
            $decodedToken = JwtManager::decodeToken(self::getToken());
        }
        catch(\Exception $exception){
            return false;
        }

        $idUser = $decodedToken["id"];
        $repo = new UtilisateurRepository();
        $user= $repo->find($idUser);
         
        if(count($user)>0){
         
            return true;
        }
        return false;
       
    }

    public static function getToken() : string
    {
        $headers = getallheaders();
    
        $authorizationHeader = $headers["Authorization"];
     
        $token = str_replace("Bearer ", "", $authorizationHeader);
        return trim($token);
    }
}