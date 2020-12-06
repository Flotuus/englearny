<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AjoutMotType;
use App\Entity\Mot;

class MotController extends AbstractController
{
    /**
     * @Route("/ajoutMot", name="ajoutMot")
     */
    public function ajoutMot(Request $request): Response
    {
        $mot = new Mot();
        $form = $this->createForm(AjoutMotType::class, $mot);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
                 $em->persist($mot); // Nous enregistrons notre nouveau thème
                 $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Mot inséré'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                 }
                 return $this->redirectToRoute('ajoutMot'); // Nous redirigeons l’utilisateur sur l’ajout d’un thème après l’insertion.
                 }

        return $this->render('mot/ajoutMot.html.twig', [
            'form'=>$form->createView() 
        ]);
    }
}
