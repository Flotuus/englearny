<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AjoutUtilisateurType;
use App\Form\ModifUtilisateurType;
use App\Entity\Utilisateur;
use App\Entity\User;

class UtilisateurController extends AbstractController
{
     /**
     * @Route("/ajoutUtilisateur", name="ajoutUtilisateur")
     */
    public function ajoutUtilisateur(Request $request): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(AjoutUtilisateurType::class, $utilisateur);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
                 $em->persist($utilisateur); // Nous enregistrons notre nouveau thème
                 $user=$utilisateur->getUser();
                 $user->setUtilisateur($utilisateur);
                 $em->persist($user);
                 $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Utilisateur inséré'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                 }
                 return $this->redirectToRoute('ajoutUtilisateur'); // Nous redirigeons l’utilisateur sur l’ajout d’un thème après l’insertion.
                 }

        return $this->render('utilisateur/ajoutUtilisateur.html.twig', [
            'form'=>$form->createView() 
        ]);
    }

    /**
    * @Route("/listeUtilisateurs", name="listeUtilisateurs")
    */
    public function listeUtilisateurs(Request $request)
    {
        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        $utilisateurs = $repoUtilisateur->findBy(array(),array('nom'=>'ASC'));
        return $this->render('utilisateur/listeUtilisateurs.html.twig', [
            'utilisateurs'=>$utilisateurs // Nous passons la liste des thèmes à la vue
        ]);
    }


      /**
     * @Route("/modifUtilisateur/{id}", name="modifUtilisateur", requirements={"id"="\d+"})
     */
    public function modifUtilisateur(int $id, Request $request): Response
    {
       
        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        $utilisateur = $repoUtilisateur->find($id);
        if($utilisateur==null){
            $this->addFlash('notice', "Cet utilisateur n'existe pas");
            return $this->redirectToRoute('listeUtilisateur');
        }
        $form = $this->createForm(ModifUtilisateurType::class,$utilisateur);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($utilisateur);
                $em->flush();
                $this->addFlash('notice', 'Utilisateur modifié');
            }   
            return $this->redirectToRoute('listeUtilisateurs');
        }

        return $this->render('utilisateur/modifUtilisateur.html.twig', [
            'form'=>$form->createView() 
        ]);
    }


     /**
     * @Route("/suppUtiliateur/{id}", name="suppUtilisateur" ,requirements={"id"="\d+"})
     */
  
    public function suppUtiliateur(int $id, Request $request): Response
    {

       
        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        $utilisateur = $repoUtilisateur->find($id);
           
        $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
        $em->remove($utilisateur); // Nous enregistrons notre nouveau thème
        $em->flush(); // Nous validons notre ajout
        $this->addFlash('notice', 'Utilisateur supprimé avec succés'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra

        return $this->redirectToRoute('listeUtilisateurs');
          
    }

    /**
     * @Route("/userProfile/{id}", name="userProfile", requirements={"id"="\d+"})
     */
     public function userprofile(int $id, Request $request)
     {
        $em = $this->getDoctrine();
       

        $repoUser = $em->getRepository(User::class);
        $user = $repoUser->find($id);
       

        return $this->render('utilisateur/user_profile.html.twig', [
            'user' => $user

        ]);
    }    



}
