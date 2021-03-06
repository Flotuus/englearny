<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Theme;
use App\Form\InscriptionType;
use App\Entity\Utilisateur;


class StaticController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function accueil(): Response
    {
        

        return $this->render('static/index.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        $em = $this->getDoctrine();
        $repoTheme = $em->getRepository(Theme::class);

        $themes = $repoTheme->findBy(array(),array('libelle'=>'ASC'));
        return $this->render('static/test.html.twig', [
            'themes'=>$themes // Nous passons la liste des thèmes à la vue
        ]);
    }
    
    /**
     * @Route("/inscrire", name="inscrire")
     */

    public function inscrire(Request $request,  UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);

        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $mdpConf = $form->get('confirmation')->getData();
                $mdp = $user->getPassword();
                if($mdp == $mdpConf){
                   // $role = $form->get('roles')->getData();
                    $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
                    $em = $this->getDoctrine()->getManager();
                    $repoUser = $this->getDoctrine()->getRepository(User::class);
                    $verif = $repoUser->findOneBy(array('email'=>$user->getEmail()));
                    if ($verif != NULL){
                        $this->addFlash('notice', 'email existant');
                        return $this->redirectToRoute('inscrire');
                    }else{
                        $user->setRoles(array('ROLE_USER'));
                        $em->persist($user);
                        $em->flush();
                    }

                   
                    $this->addFlash('notice', 'Inscription réussie');
                    return $this->redirectToRoute('ajoutUtilisateur', array('id'=>$user->getId()));
                }
                
                else{
                    $this->addFlash('notice', 'Erreur de mot de passe');
                    return $this->redirectToRoute('inscrire');
                }
            }
        }        

        return $this->render('static/inscrire.html.twig', [
           'form'=>$form->createView()
        ]);
    }

  
     /**
     * @Route("/modifRole/{id}", name="modifRole", requirements={"id"="\d+"})
     */
    public function modifRole(int $id, Request $request): Response
    {
       
        $em = $this->getDoctrine();
        $repoUser = $em->getRepository(User::class);
        $user = $repoUser->find($id);
        if($user==null){
            $this->addFlash('notice', "Cet utilisateur n'existe pas");
            return $this->redirectToRoute('listeUtilisateur');
        }
       
        if ($request->isMethod('POST')) {
            $this->addFlash('notice', 'Utilisateur modifié');
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setRoles(array('ROLE_ADMIN'));
                // get le tableau 
                $em->persist($user);
                $em->flush();
                $this->addFlash('notice', 'Utilisateur modifié');
            }   
            return $this->redirectToRoute('userProfile');
        }

        return $this->render('utilisateur/user_profile.html.twig', [
            'user' => $user

        ]);
    }



}
