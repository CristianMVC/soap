<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Zend\Soap;

class DefaultController extends Controller
{
    
    public function init()
    {
        // No cache
        ini_set('soap.wsdl_cache_enable', 0);
        ini_set('soap.wsdl_cache_ttl', 0);
    }
    
    
    public function indexAction()
    {
        
        $funcion = $this->get('GenerarUsuario');
      //  $funcion->generarUsuario("palito ortega","aaaaaaa","aaaaaaaa");
        $funcion->getUsuarios();
        
        
        return $this->render('ApiBundle:Default:index.html.twig');
    }
    
    
     public function checkAction()
    {
       
        if(isset($_GET['wsdl'])) {
            return $this->handleWSDL($this->generateUrl('acme_api_soap_check', array(), true), 'GenerarUsuario'); 
        } else {
            return $this->handleSOAP($this->generateUrl('acme_api_soap_check', array(), true), 'GenerarUsuario'); 
        }
 }

    /**
    * return the WSDL
    */
    public function handleWSDL($uri, $class)
    {
        
        
        // Soap auto discover
        $autodiscover = new Soap\AutoDiscover();
        $autodiscover->setClass($this->get($class));
       
        $autodiscover->setUri($uri);

       // Response
       $response = new Response();
       $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
       ob_start();

       // Handle Soap
       $autodiscover->handle();
       $response->setContent(ob_get_clean());
       return $response;
    }

    /**
     * execute SOAP request
     */
    public function handleSOAP($uri, $class)
    {
        
          
        // Soap server
        $soap = new Soap\Server(null,
            array('location' => $uri,
            'uri' => $uri,
        ));
        $soap->setClass($this->get($class));
      

        // Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        // Handle Soap
        $soap->handle();
        $response->setContent(ob_get_clean());
        return $response;
    }
    
    
    
    
}
