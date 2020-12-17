<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Liste;
use App\Form\AjoutListeType;
use App\Form\ModifListeType;

class ListeController extends AbstractController
{
    /**
     * @Route("/ajoutListe", name="ajoutListe")
     */
    public function ajoutListe(Request $request): Response
    {

        $liste = new Liste();
        $form = $this->createForm(AjoutListeType::class,$liste);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($liste);
                $em->flush();

                $this->addFlash('notice','Liste Ajoutée');
            }
            return $this->redirectToRoute('ajoutListe');
        }

        return $this->render('liste/ajoutListe.html.twig', [
            'form'=>$form->createView()        
        ]);

    }

    /**
     * @Route("/listeListes", name="listeListes")
     */
    public function listeListes(Request $request): Response
    {
        $em = $this->getDoctrine();
        $repoListe = $em->getRepository(Liste::class);
        
        if ($request->get('supp')!=null){
            $liste = $repoListe->find($request->get('supp'));
            if($liste!=null){
            $em->getManager()->remove($liste);
            $em->getManager()->flush();
            }
            $this->addFlash('notice', 'Liste supprimée');
            return $this->redirectToRoute('listeListes');
        }
           
        
        $listes = $repoListe->findBy(array(),array('libelle'=>'ASC'));
        return $this->render('liste/listeListes.html.twig', [
            'listes'=>$listes
        ]);

    }

    /**
     * @Route("/modifListe/{id}", name="modifListe",requirements={"id"="\d+"})
     */
    public function modifListe(int $id, Request $request): Response
    {
        $em = $this->getDoctrine();
        $repoListe = $em->getRepository(Liste::class);
        $liste = $repoListe->find($id);

        if($liste==null){
            $this->addFlash('notice', "Cette liste n'existe pas");
            return $this->redirectToRoute('listeListe');
        }

        $form = $this->createForm(ModifListeType::class,$liste);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($liste);
                $em->flush();
                $this->addFlash('notice', 'Liste modifiée');
            }
            return $this->redirectToRoute('listeListes');
        }
        return $this->render('liste/modifListe.html.twig', [
            'form'=>$form->createView()
        ]);
           
    }
}

