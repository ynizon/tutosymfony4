<?php 

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyController extends Controller
{
	
	protected function getRepository($sEntity)
    {		
		$em = $this->getDoctrine()->getManager();	
		return $em->getRepository("App\\Entity\\".$sEntity);
    }	
}