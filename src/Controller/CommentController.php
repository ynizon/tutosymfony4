<?php // src/Controller/DefaultController.php

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\TranslatorInterface;
use App\Controller\MyController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CommentType;

use App\Entity\Comment;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommentController extends MyController
{
	
    public function index(): Response
    {		
		//$em = $this->getDoctrine()->getManager();		
		//$commentRepository = $em->getRepository('App\Entity\Comment');
		//Grace a l heritage
		$commentRepository = $this->getRepository('Comment');
		
		$comments = $commentRepository->findAll();
		$form = $this->get('form.factory')->create();
		
        return $this->render('comment/index.html.twig', ["comments"=>$comments, "form"=>$form->createView()]);
    }
	
	
	 public function pagination($page): Response
    {		
		//$em = $this->getDoctrine()->getManager();		
		//$commentRepository = $em->getRepository('App\Entity\Comment');
		//Grace a l heritage
		$commentRepository = $this->getRepository('Comment');
		
		$iNbComment = $this->container->getParameter('pagination');
		$comments = $commentRepository->getComments($page,$iNbComment);
		$form = $this->get('form.factory')->create();
		
		// On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
		$nbPages = ceil(count($comments) / $iNbComment);

		// Si la page n'existe pas, on retourne une 404
		if ($page > $nbPages) {
		  throw $this->createNotFoundException("La page ".$page." n'existe pas.");
		}

		
        return $this->render('comment/pagination.html.twig', ["comments"=>$comments, "form"=>$form->createView(),"nbPages"=>$nbPages,"page"=>$page]);
    }
	
	public function add(Request $request){
		$em = $this->getDoctrine()->getManager();
		$materielRepository = $em->getRepository('App\Entity\Materiel');
		$materiel = $materielRepository->find($request->request->get("comment")["materiel_id"]);
		
		$comment = new Comment();
		$comment->setMateriel($materiel);
		
		//Creation du formulaire externe
		$form = $this->get('form.factory')->create(CommentType::class, $comment);
		
		$bAdd = false;
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {			
					
				$em->persist($comment);
				$em->flush();//Valide la transaction
			
				$request->getSession()->getFlashBag()->add('success', 'Commentaire bien enregistré.');
				// Puis on redirige vers la page de visualisation 
				return $this->redirectToRoute('materiel_show', array('id'=>$comment->getMaterielId()));
			}else{
				$request->getSession()->getFlashBag()->add('error', 'Commentaire non enregistré.');
				$bAdd = true;
			}
		}else{
			$bAdd = true;
		}
		
		if ($bAdd){
			
			return $this->render('comment/add.html.twig', ["form"=>$form->createView()]);
		}
	}
	
	
	public function edit($id, Request $request){
		$em = $this->getDoctrine()->getManager();
		$commentRepository = $em->getRepository('App\Entity\Comment');
		$comment = $commentRepository->find($id);		
		
		//Creation du formulaire externe
		$form = $this->get('form.factory')->create(CommentType::class, $comment);		
		
		if (null === $comment) {
			throw new NotFoundHttpException("Le Commentaire id ".$id." n'existe pas.");
		}

		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {			
				$em->persist($comment);
				$em->flush();//Valide la transaction
			
				$request->getSession()->getFlashBag()->add('success', 'Commentaire bien enregistré.');
				// Puis on redirige vers la page de visualisation 
				return $this->redirectToRoute('materiel_show', array('id'=>$comment->getMaterielId()));
			}else{
				$request->getSession()->getFlashBag()->add('error', 'Commentaire non enregistré.');
			}
		}		
		return $this->render('comment/add.html.twig', ['comment'=>$comment,"form"=>$form->createView()]);
	}
	
	public function delete($id, Request $request){
		$em = $this->getDoctrine()->getManager();
		$commentRepository = $em->getRepository('App\Entity\Comment');
		$comment = $commentRepository->find($id);
		
		if (null === $comment) {
			throw new NotFoundHttpException("Le Commentaire id ".$id." n'existe pas.");
		}else{
			$em->remove($comment);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'Commentaire supprimé.');
		}

		return $this->redirectToRoute('materiel_show', array('id'=>$comment->getMaterielId()));
	}
	
	public function show($slug, Request $request){
		$em = $this->getDoctrine()->getManager();
		$commentRepository = $em->getRepository('App\Entity\Comment');
		$comments = $commentRepository->findBySlug($slug);
		$comment = null;
		foreach ($comments as $comment){
			
		}
		
		if (null === $comment) {
			throw new NotFoundHttpException("Le Commentaire n'existe pas.");
		}
		
		/*
		$request->setLocale('en');	
		$session = $request->getSession();
		$session->set('_locale', "en");
		$translator = $this->get('translator');
		echo $request->getLocale();    		
		echo $translator->trans('hello');exit();
		*/
		
		
		return $this->render('comment/show.html.twig', ['comment'=>$comment]);
	}
}