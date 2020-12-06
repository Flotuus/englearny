<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AjoutMotType;
use App\Form\ModifMotType;
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

    /**
    * @Route("/listeMots", name="listeMots")
    */
    public function listeMots(Request $request)
    {
        $em = $this->getDoctrine();
        $repoMot = $em->getRepository(Mot::class);
        $mots = $repoMot->findBy(array(),array('libelle'=>'ASC'));
        return $this->render('mot/listeMots.html.twig', [
            'mots'=>$mots // Nous passons la liste des thèmes à la vue
        ]);
    }

     /**
     * @Route("/modifMot/{id}", name="modifMot", requirements={"id"="\d+"})
     */
    public function modifMot(int $id, Request $request): Response
    {
       
        $em = $this->getDoctrine();
        $repoMot = $em->getRepository(Mot::class);
        $mot = $repoMot->find($id);
        if($mot==null){
            $this->addFlash('notice', "Ce mot n'existe pas");
            return $this->redirectToRoute('listeMots');
        }
        $form = $this->createForm(ModifMotType::class,$mot);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($mot);
                $em->flush();
                $this->addFlash('notice', 'Mot modifié');
            }   
            return $this->redirectToRoute('listeMots');
        }

        return $this->render('mot/modifMot.html.twig', [
            'form'=>$form->createView() 
        ]);
    }


     /**
     * @Route("/suppMot/{id}", name="suppMot" ,requirements={"id"="\d+"})
     */
  
    public function suppMot(int $id, Request $request): Response
    {

       
        $em = $this->getDoctrine();
        $repoMot = $em->getRepository(Mot::class);
        $mot = $repoMot->find($id) ; 
           
        $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
        $em->remove($mot); // Nous enregistrons notre nouveau thème
        $em->flush(); // Nous validons notre ajout
        $this->addFlash('notice', 'Mot supprimé avec succés'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
            
        
        return $this->redirectToRoute('listeMots');
          
    }


}
