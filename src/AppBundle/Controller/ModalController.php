<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
use AppBundle\Entity\SousCategorie;
use AppBundle\Form\Type\AddCategoryFormType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ModalController extends Controller
{
    /**
     * @Route("/modal/addCategory/{nomCategorie}", name="modal_add_category", defaults={"nomCategorie" = 0})
     * @ParamConverter("nom", class="AppBundle:Categorie", options={"mapping" : {"nomCategorie" : "nom"}})
     */
	public function modalAddCategoryAction(Request $request, Categorie $nom, EntityManager $em)
	{
		if (!$request->isXmlHttpRequest()) return new Response('', 400);
		$sousCategorie = new SousCategorie();
		$sousCategorie->setCategorie($nom);
		$form = $this->createForm(AddCategoryFormType::class, $sousCategorie);
		$form->handleRequest($request);
		$response = new Response();
		if ($form->isValid()) {
			$em->persist($form->getData());
			$em->flush();
			$this->addFlash('success', 'La catégorie a été ajoutée.');
			$response->setStatusCode(200);
		}
		else if (!$form->isValid() && $form->isSubmitted()) {
			$response->setStatusCode(401);
		}
		$response->setContent($this->renderView('modal/add_category.html.twig', [
			'form' => $form->createView(),
			'categorie' => $nom->getNom()
		]));
		return $response;
    }

}
