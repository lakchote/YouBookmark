<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
use AppBundle\Entity\Fichier;
use AppBundle\Entity\SousCategorie;
use AppBundle\Form\Type\AddFileFormType;
use AppBundle\Service\DeleteService;
use AppBundle\Service\FileUploader;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
	/**
	 * @Route("/", name="home")
	 */
    public function indexAction()
    {
		return $this->render('index/home.html.twig');
    }

	/**
	 * @Route("/get_category", name="get_category")
	 */
	public function getCategoryAction(Request $request, EntityManager $em)
	{
		$result = $em->getRepository('AppBundle:SousCategorie')->getSousCategoriesForACategorie($request->query->get('category'));
		return new Response(json_encode($result), 200);
    }

	/**
	 * @Route("/show/{category}/{sous_categorie}",name="show_sous_categorie")
	 * @ParamConverter("categorie", options={"mapping" : {"category" : "nom"}})
	 * @ParamConverter("sousCategorie", options={"mapping" : {"sous_categorie": "nom"}})
	 */
	public function showSousCategorieAction(Categorie $categorie, SousCategorie $sousCategorie, EntityManager $em, Request $request, FileUploader $fileUploader)
	{
		$form = $this->createForm(AddFileFormType::class);
		$form->handleRequest($request);
		if($form->isValid()) {
			$fichier = $form->getData();
			$fileUploader->uploadFile($fichier, $sousCategorie);
			$this->addFlash('success', 'Le fichier a été ajouté.');
		}
		$fichiers = $em->getRepository('AppBundle:Fichier')->getFilesForASousCategorie($sousCategorie->getNom());
		return $this->render('index/show_category.html.twig', [
			'sousCategorie' => $sousCategorie,
			'fichiers' => $fichiers,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/delete/{nom}", name="delete_fichier")
	 */
	public function deleteFichierAction(Fichier $fichier, DeleteService $deleteFichier, Request $request)
	{
		$deleteFichier->deleteFile($fichier);
		$this->addFlash('success', 'Fichier supprimé.');
		return $this->redirect($request->headers->get('referer'));
	}

}
