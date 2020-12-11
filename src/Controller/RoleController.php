<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AjoutRoleType;
use App\Form\ModifRoleType;
use App\Entity\Role;


class RoleController extends AbstractController
{
     /**
     * @Route("/ajoutRole", name="ajoutRole")
     */
    public function ajoutRole(Request $request): Response
    {
        $role = new Role();
        $form = $this->createForm(AjoutRoleType::class, $role);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
                 $em->persist($role); // Nous enregistrons notre nouveau thème
                 $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'role inséré'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                 }
                 return $this->redirectToRoute('ajoutRole'); // Nous redirigeons l’utilisateur sur l’ajout d’un thème après l’insertion.
                 }

        return $this->render('role/ajoutRole.html.twig', [
            'form'=>$form->createView() 
        ]);
    }

      /**
    * @Route("/listeRoles", name="listeRoles")
    */
    public function listeRoles(Request $request)
    {
        $em = $this->getDoctrine();
        $repoRole = $em->getRepository(Role::class);
        $roles = $repoRole->findBy(array(),array('libelle'=>'ASC'));
        return $this->render('role/listeRoles.html.twig', [
            'roles'=>$roles // Nous passons la liste des thèmes à la vue
        ]);
    }

      /**
     * @Route("/modifRole/{id}", name="modifRole", requirements={"id"="\d+"})
     */
    public function modifRole(int $id, Request $request): Response
    {
       
        $em = $this->getDoctrine();
        $repoRole = $em->getRepository(Role::class);
        $role = $repoRole->find($id);
        if($role==null){
            $this->addFlash('notice', "Ce role n'existe pas");
            return $this->redirectToRoute('listeRoles');
        }
        $form = $this->createForm(ModifRoleType::class,$role);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($role);
                $em->flush();
                $this->addFlash('notice', 'Role modifié');
            }   
            return $this->redirectToRoute('listeRoles');
        }

        return $this->render('role/modifRole.html.twig', [
            'form'=>$form->createView() 
        ]);
    }


     /**
     * @Route("/suppRole/{id}", name="suppRole" ,requirements={"id"="\d+"})
     */
  
    public function suppRole(int $id, Request $request): Response
    {

       
        $em = $this->getDoctrine();
        $repoRole = $em->getRepository(Role::class);
        $role = $repoRole->find($id);
           
        $em = $this->getDoctrine()->getManager(); // On récupère le gestionnaire des entités
        $em->remove($role); // Nous enregistrons notre nouveau thème
        $em->flush(); // Nous validons notre ajout
        $this->addFlash('notice', 'Role supprimé avec succés'); // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
            
        
        return $this->redirectToRoute('listeRoles');
          
    }



}
