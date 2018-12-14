<?php

namespace ApiBundle\Services;

class CheckService
{
    /**
     * Check soap service, display name when called
     * @param string $name 
     * @return mixed
     */
    public function check($name)
    {
        return 'Hello '.$name;
    }
    
    
     /**
     * Check soap service, display name when called
     * @param string $nombre 
     * @param string $mail
     * @param string $pass
     * @return mixed
     */    
public function generarUsuario($nombre,$mail,$pass)
{
    
    
    
    return "Ok";
    
}    
    
    
    
    
    
}


?>