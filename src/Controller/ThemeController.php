<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AjoutThemeType;
use App\Form\ModifThemeType;
use App\Entity\Theme;

class ThemeController extends AbstractController
{
    /**
     * @Route("/ajoutTheme", name="ajoutTheme")
     */
    public function ajoutTheme( Request $request): Response
    {
        $theme = new Theme();
        $form = $this->createForm(AjoutThemeType::class,$theme); 
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 

                $em->persist($theme); 
                $em->flush();
                $this->addFlash('notice', 'Thème inséré'); 
            }
            return $this->redirectToRoute('ajoutTheme'); 
        }

        return $this->render('theme/ajoutTheme.html.twig', [
            'form'=>$form->createView()
            ]);
   
    }


    /**
     * @Route("/listeThemes", name="listeThemes")
    */
    public function listeThemes(Request $request)
    {
        $em = $this->getDoctrine();
        $repoTheme = $em->getRepository(Theme::class);
           
        if ($request->get('supp')!=null){
            $theme = $repoTheme->find($request->get('supp'));
            if($theme!=null){
            $em->getManager()->remove($theme);
            $em->getManager()->flush();
            }
            $this->addFlash('notice', 'Thème supprimé');
            return $this->redirectToRoute('listeThemes');
        }
           

        $themes = $repoTheme->findBy(array(),array('libelle'=>'ASC'));
        return $this->render('theme/listeThemes.html.twig', [
            'themes'=>$themes // Nous passons la liste des thèmes à la vue
        ]);
    }

    /**
     * @Route("/modifTheme/{id}", name="modifTheme", requirements={"id"="\d+"})
    */
    public function modifTheme(int $id, request $request)
    {
        $em = $this->getDoctrine();
        $repoTheme = $em->getRepository(Theme::class);
        $theme = $repoTheme->find($id);
            if($theme==null){
                $this->addFlash('notice', "Ce thème n'existe pas");
                return $this->redirectToRoute('liste_themes');
            }
            $form = $this->createForm(ModifThemeType::class,$theme);
                if ($request->isMethod('POST')) {
                    $form->handleRequest($request);
                    if ($form->isSubmitted() && $form->isValid()) {
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($theme);
                        $em->flush();
                        $this->addFlash('notice', 'Thème modifié');
                    }   
                    return $this->redirectToRoute('listeThemes');
                }

            return $this->render('theme/modifTheme.html.twig', [
                'form'=>$form->createView() // Nous passons la liste des thèmes à la vue
        ]);
    }


}
