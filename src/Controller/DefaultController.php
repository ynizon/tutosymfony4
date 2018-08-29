<?php // src/Controller/DefaultController.php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Materiel;
use App\Entity\Comment;
use App\Form\CommentType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController extends Controller
{
    public function index(): Response
    {
		$em = $this->getDoctrine()->getManager();
		$materielRepository = $em->getRepository('App\Entity\Materiel');
		$materiels = $materielRepository->findAll();//getRandom();
		$form = $this->get('form.factory')->create();
		
		$gfx_data = array();
		foreach ($materiels as $materiel){
			$gfx_data[] = array($materiel->getNom(), (int) $materiel->getDuree());
		}
		
        return $this->render('index.html.twig', ["materiels"=>$materiels, "form"=>$form->createView(),"gfx_data"=>$gfx_data]);
    }
	
	public function add(Request $request){
		$materiel = new Materiel();
		
		$form = $this->get('form.factory')->createBuilder(FormType::class, $materiel)
		  ->add('duree',      IntegerType::class)
		  ->add('nom',     TextType::class)
		  ->add('save',      SubmitType::class)
		  ->getForm()
		;		
	
		$bAdd = false;
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {			
				$em = $this->getDoctrine()->getManager();			
				$em->persist($materiel);
				$em->flush();//Valide la transaction
			
				$request->getSession()->getFlashBag()->add('success', 'Matériel bien enregistré.');
				// Puis on redirige vers la page de visualisation 
				return $this->redirectToRoute('index', array());
			}else{
				$request->getSession()->getFlashBag()->add('error', 'Matériel non enregistré.');
				$bAdd = true;
			}
		}else{
			$bAdd = true;
		}
		
		if ($bAdd){
			// On crée le FormBuilder grâce au service form factory
			$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $materiel);

			// On ajoute les champs de l'entité que l'on veut à notre formulaire
			$formBuilder
			  ->add('duree',     IntegerType::class)
			  ->add('nom',     TextType::class)			  
			  ->add('save',      SubmitType::class)
			;
			

			// À partir du formBuilder, on génère le formulaire
			$form = $formBuilder->getForm();
			
			return $this->render('add.html.twig', ["form"=>$form->createView()]);
		}
	}
	
	
	public function edit($id, Request $request){
		$em = $this->getDoctrine()->getManager();
		$materielRepository = $em->getRepository('App\Entity\Materiel');
		$materiel = $materielRepository->find($id);
		
		// On crée le FormBuilder grâce au service form factory
		$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $materiel);

		// On ajoute les champs de l'entité que l'on veut à notre formulaire
		$formBuilder
		  ->add('duree',     IntegerType::class)
		  ->add('nom',     TextType::class)			  
		  ->add('save',      SubmitType::class)
		;
		

		// À partir du formBuilder, on génère le formulaire
		$form = $formBuilder->getForm();	
		
		if (null === $materiel) {
			throw new NotFoundHttpException("Le materiel id ".$id." n'existe pas.");
		}

		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {			
				$em->persist($materiel);
				$em->flush();//Valide la transaction
			
				$request->getSession()->getFlashBag()->add('success', 'Matériel bien enregistré.');
				// Puis on redirige vers la page de visualisation 
				return $this->redirectToRoute('index', array());
			}else{
				$request->getSession()->getFlashBag()->add('error', 'Matériel non enregistré.');
			}
		}		
		return $this->render('edit.html.twig', ['materiel'=>$materiel,"form"=>$form->createView()]);
	}
	
	
	public function delete($id, Request $request){
		$em = $this->getDoctrine()->getManager();
		$materielRepository = $em->getRepository('App\Entity\Materiel');
		$materiel = $materielRepository->find($id);
		
		if (null === $materiel) {
			throw new NotFoundHttpException("Le materiel id ".$id." n'existe pas.");
		}else{
			$em->remove($materiel);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'Matériel supprimé.');
		}

		return $this->redirectToRoute('index', array());
	}
	
	public function show($id, Request $request){
		$em = $this->getDoctrine()->getManager();
		$materielRepository = $em->getRepository('App\Entity\Materiel');
		$materiel = $materielRepository->find($id);
		
		// On récupère la liste des commentaires
		$listComments = $em
		  ->getRepository('App\Entity\Comment')
		  ->findBy(array('materiel' => $materiel))
		;

		//Creation du formulaire externe
		$comment = new Comment();
		$comment->setMaterielId($materiel->getId());
		$form = $this->get('form.factory')->create(CommentType::class, $comment);
		
		return $this->render('show.html.twig', ['materiel'=>$materiel,'comments'=>$listComments,'form'=>$form->createView()]);
	}
	
	
}