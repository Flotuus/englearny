<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categorie;
use App\Form\AjoutCategorieType;
use App\Form\ModifCategorieType;


class CategorieController extends AbstractController
{
    /**
     * @Route("/ajoutCategorie", name="ajoutCategorie")
     */
    public function ajoutCategorie(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(ajoutCategorieType::class,$categorie);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush();

                $this->addFlash('notice','Catégorie Ajoutée');
            }
            return $this->redirectToRoute('ajoutCategorie');
        }

        return $this->render('categorie/ajoutCategorie.html.twig', [
            'form'=>$form->createView()        
        ]);
    }

    /**
     * @Route("/listeCategorie", name="listeCategorie")
     */
    public function listeCategorie(Request $request): Response
    {
        $em = $this->getDoctrine();
        $repoCategorie = $em->getRepository(Categorie::class);
        
        if ($request->get('supp')!=null){
            $categorie = $repoCategorie->find($request->get('supp'));
            if($categorie!=null){
            $em->getManager()->remove($categorie);
            $em->getManager()->flush();
            }
            $this->addFlash('notice', 'Catégorie supprimée');
            return $this->redirectToRoute('listeCategorie');
        }
           
        
        $categories = $repoCategorie->findBy(array(),array('libelle'=>'ASC'));
        return $this->render('categorie/listeCategorie.html.twig', [
            'categories'=>$categories 
        ]);

    }

    /**
     * @Route("/modifCategorie/{id}", name="modifCategorie",requirements={"id"="\d+"})
     */
    public function modifCategorie(int $id, Request $request): Response
    {
        $em = $this->getDoctrine();
        $repoCategorie = $em->getRepository(Categorie::class);
        $categorie = $repoCategorie->find($id);

        if($categorie==null){
            $this->addFlash('notice', "Cette catégorie n'existe pas");
            return $this->redirectToRoute('listeCategorie');
        }

        $form = $this->createForm(ModifCategorieType::class,$categorie);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush();
                $this->addFlash('notice', 'Catégorie modifiée');
            }
            return $this->redirectToRoute('listeCategorie');
        }
        return $this->render('categorie/modifCategorie.html.twig', [
            'form'=>$form->createView()
        ]);
           
    }
}
