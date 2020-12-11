<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AjoutAbonnementType;
use App\Form\ModifAbonnementType;
use App\Entity\Abonnement;

class AbonnementController extends AbstractController
{
    /**
     * @Route("/ajoutAbonnement", name="ajoutAbonnement")
     */
    public function ajoutAbonnement(Request $request): Response
    {
        $abonnement = new Abonnement();
        $form = $this->createForm(AjoutAbonnementType::class, $abonnement);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
                 $em->persist($abonnement); // Nous enregistrons notre nouveau thème
                 $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'abonnement inséré'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                 }
                 return $this->redirectToRoute('ajoutAbonnement'); // Nous redirigeons l’utilisateur sur l’ajout d’un thème après l’insertion.
                 }

        return $this->render('abonnement/ajoutAbonnement.html.twig', [
            'form'=>$form->createView() 
        ]);
    }

      /**
    * @Route("/listeAbonnements", name="listeAbonnements")
    */
    public function listeAbonnements(Request $request)
    {
        $em = $this->getDoctrine();
        $repoAbonnement = $em->getRepository(Abonnement::class);
        $abonnements = $repoAbonnement->findBy(array(),array('libelle'=>'ASC'));
        return $this->render('abonnement/listeAbonnements.html.twig', [
            'abonnements'=>$abonnements // Nous passons la liste des thèmes à la vue
        ]);
    }


      /**
     * @Route("/modifAbonnement/{id}", name="modifAbonnement", requirements={"id"="\d+"})
     */
    public function modifAbonnement(int $id, Request $request): Response
    {
       
        $em = $this->getDoctrine();
        $repoAbonnement = $em->getRepository(Abonnement::class);
        $abonnement = $repoAbonnement->find($id);
        if($abonnement==null){
            $this->addFlash('notice', "Cet abonnement n'existe pas");
            return $this->redirectToRoute('listeAbonnements');
        }
        $form = $this->createForm(ModifAbonnementType::class,$abonnement);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($abonnement);
                $em->flush();
                $this->addFlash('notice', 'Abonnement modifié');
            }   
            return $this->redirectToRoute('listeAbonnements');
        }

        return $this->render('role/modifRole.html.twig', [
            'form'=>$form->createView() 
        ]);
    }


     /**
     * @Route("/suppAbonnement/{id}", name="suppAbonnement" ,requirements={"id"="\d+"})
     */
  
    public function suppAbonnement(int $id, Request $request): Response
    {

       
        $em = $this->getDoctrine();
        $repoAbonnement = $em->getRepository(Abonnement::class);
        $abonnement = $repoAbonnement->find($id);
           
        $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
        $em->remove($abonnement); // Nous enregistrons notre nouveau thème
        $em->flush(); // Nous validons notre ajout
        $this->addFlash('notice', 'Abonnement supprimé avec succés'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
            
        
        return $this->redirectToRoute('listeAbonnements');
          
    }


}
