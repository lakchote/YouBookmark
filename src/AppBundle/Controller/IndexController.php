<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
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
}
