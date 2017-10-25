<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
use AppBundle\Entity\SousCategorie;
use AppBundle\Form\Type\AddCategoryFormType;
use AppBundle\Form\Type\RemoveCategoryFormType;
use AppBundle\Service\DeleteService;
use AppBundle\Traits\FormValidationTrait;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ModalController extends Controller
{
	use FormValidationTrait;
    /**
     * @Route("/modal/addCategory/{nomCategorie}", name="modal_add_category", defaults={"nomCategorie" = 0})
     * @ParamConverter("nom", class="AppBundle:Categorie", options={"mapping" : {"nomCategorie" : "nom"}})
     */
	public function modalAddCategoryAction(Request $request, Categorie $nom, EntityManager $em, DeleteService $deleteService)
	{
		if (!$request->isXmlHttpRequest()) return new Response('', 400);
		$sousCategorie = new SousCategorie();
		$sousCategorie->setCategorie($nom);
		$form = $this->createForm(AddCategoryFormType::class, $sousCategorie);
		$form->handleRequest($request);
		$response = new Response();
		$this->checkFormIsValid($form, $em, $response, 'add', 'La catégorie a été ajoutée.', $deleteService);
		return $response->setContent($this->renderView('modal/add_category.html.twig', [
			'form' => $form->createView(),
			'categorie' => $nom->getNom()
		]));
    }

	/**
	 * @Route("/modal/removeCategory", name="modal_remove_category")
	 */
	public function modalRemoveCategoryAction(Request $request, EntityManager $em, DeleteService $deleteService)
	{
		if (!$request->isXmlHttpRequest()) return new Response('', 400);
		$form = $this->createForm(RemoveCategoryFormType::class);
		$form->handleRequest($request);
		$response = new Response();
		$this->checkFormIsValid($form, $em, $response, 'del', 'La catégorie a été supprimée.', $deleteService);
		return $response->setContent($this->renderView('modal/remove_category.html.twig', [
			'form' => $form->createView()
		]));
	}
}
