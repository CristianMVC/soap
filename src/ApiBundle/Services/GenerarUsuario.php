<?php
namespace ApiBundle\Services;

use Doctrine\ORM\EntityManager;
use ApiBundle\Entity\Usuario\Post;
class GenerarUsuario 
{
    
private $em;   
    
public function __construct(EntityManager $entityManager)
{
    $this->em = $entityManager;
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
  
    $usuario = new Post();
    $usuario->setNombre($nombre);
    $usuario->setPass($pass);
    $usuario->setEmail($mail);
   
    if($error = $this->validarDatos($mail,$pass)){
   try{ 
    
    $this->em->persist($usuario);
    $this->em->flush();
    
    }catch (Exception $e)
    {
        return $e->getMessage();
    }
    
    
    return "Ok";
    }else
    {
        return $error;
        
    }
}    
    
     
   private function validarDatos($mail,$pass)
   {
      if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        
        if(isset($pass))
        {
          return md5($pass);
        }else
        {
            return "Password invalido";
        } 
         
      }else
      {
        return "Email invalido";
        
      }
     return true;
    
    
   }  
     
        
}


?>