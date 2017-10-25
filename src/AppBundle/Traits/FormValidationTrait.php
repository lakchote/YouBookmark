<?php


namespace AppBundle\Traits;


use AppBundle\Service\DeleteService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;

trait FormValidationTrait {

	public function checkFormIsValid(Form $form, EntityManager $em, Response $response, $modalType, $message, DeleteService $deleteService) {
		if ($form->isValid()) {
			if($modalType === 'add') {
				$em->persist($form->getData());
				$em->flush();
			} else {
				$sousCategorie = $form->getData();
				$entity = $em->getRepository('AppBundle:SousCategorie')->findOneBy([
					'nom' => $sousCategorie->getNom()
				]);
				$deleteService->deleteDirectory($entity);
				$em->remove($entity);
				$em->flush();
			}
			$this->addFlash('success', $message);
			$response->setStatusCode(200);
		}
		else if (!$form->isValid() && $form->isSubmitted()) {
			$response->setStatusCode(401);
		}
	}
}
