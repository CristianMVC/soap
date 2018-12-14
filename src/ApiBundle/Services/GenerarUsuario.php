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
  
  
   $resultado = $this->validarDatos($mail,$pass);
   
   if($resultado == 1)
     {
        return "Password mal definido";
     }
    if($resultado == 2)
     {
        return "Email mal definido";
     }
     
    $usuario = new Post();
    $usuario->setNombre($nombre);
    $usuario->setPass($resultado);
    $usuario->setEmail($mail);
       
   try{ 
    
    $this->em->persist($usuario);
    $this->em->flush();
    
    }catch (Exception $e)
    {
        return $e->getMessage();
    }
    
    
    return "Ok";
    
}    
      
   
  /**
     * @return array
     */    
   public function getUsuarios()
   {
    
    try{
        $values = $this->em->getRepository('ApiBundle:Usuario\Post')->findAll();
       }catch(Exception $e)
       {
         return $e->getMessage();
       } 
      
      return $values;
          
   }
   
   
   /**
     * Check soap service, display name when called
     * @param string $id
     * @return mixed
     */    
   public function deleteUser($id)
   {
    
    try{
         $value = $this->em->getRepository('ApiBundle:Usuario\Post')->find($id);
         $this->em->remove($value);
         $this->em->flush();
         
       }catch(Exception $e)
       {
        
        return $e->getMessage();
       }
    
     return "Usuario removido";
    
   }
   
   
    
     
   private function validarDatos($mail,$pass)
   {
      if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        
        if(isset($pass))
        {
          return md5($pass);
        }else
        {
            return 1;
        } 
         
      }else
      {
        return 2;
        
      }
    
    
    
   }  
     
        
}


?>