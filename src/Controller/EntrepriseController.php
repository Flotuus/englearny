<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Entreprise;
use App\Form\AjoutEntrepriseType;
use App\Form\ModifEntrepriseType;

class EntrepriseController extends AbstractController
{
    /**
     * @Route("/ajoutEntreprise", name="ajoutEntreprise")
     */
    public function ajoutEntreprise(Request $request): Response
    {

        $entreprise = new Entreprise();
        $form = $this->createForm(AjoutEntrepriseType::class,$entreprise);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($entreprise);
                $em->flush();

                $this->addFlash('notice','Entreprise Ajoutée');
            }
            return $this->redirectToRoute('ajoutEntreprise');
        }

        return $this->render('entreprise/ajoutEntreprise.html.twig', [
            'form'=>$form->createView()        
        ]);

    }

    /**
     * @Route("/listeEntreprises", name="listeEntreprises")
     */
    public function listeEntreprises(Request $request): Response
    {
        $em = $this->getDoctrine();
        $repoEntreprise = $em->getRepository(Entreprise::class);
        $getEntreprise = $repoEntreprise->getUtilisateurs();

        if ($request->get('supp')!=null){
            $entreprise = $repoEntreprise->find($request->get('supp'));
            if($entreprise!=null){
            $em->getManager()->remove($entreprise);
            $em->getManager()->flush();
            }
            $this->addFlash('notice', 'Entreprise supprimée');
            return $this->redirectToRoute('listeEntreprises');
        }
           
        
        $entreprises = $repoEntreprise->getUtilisateurs();

        return $this->render('entreprise/listeEntreprises.html.twig', [
            'entreprises'=>$entreprises

        ]);

    }

    /**
     * @Route("/modifEntreprise/{id}", name="modifEntreprise",requirements={"id"="\d+"})
     */
    public function modifEntreprise(int $id, Request $request): Response
    {
        $em = $this->getDoctrine();
        $repoEntreprise = $em->getRepository(Entreprise::class);
        $entreprise = $repoEntreprise->find($id);

        if($entreprise==null){
            $this->addFlash('notice', "Cette entreprise n'existe pas");
            return $this->redirectToRoute('listeEntreprise');
        }

        $form = $this->createForm(ModifEntrepriseType::class,$entreprise);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entreprise);
                $em->flush();
                $this->addFlash('notice', 'Entreprise modifiée');
            }
            return $this->redirectToRoute('listeEntreprises');
        }
        return $this->render('entreprise/modifEntreprise.html.twig', [
            'form'=>$form->createView()
        ]);
           
    }
}
