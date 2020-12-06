<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Test;
use App\Form\AjoutTestType;
use App\Form\ModifTestType;

class TestController extends AbstractController
{
    /**
     * @Route("/ajoutTest", name="ajoutTest")
     */
    public function index(Request $request): Response
    {
        $test = new Test();
        $form = $this->createForm(AjoutTestType::class,$test);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($test);
                $em->flush();

                $this->addFlash('notice','Test Ajouté');
            }
            return $this->redirectToRoute('ajoutTest');
        }

        return $this->render('test/ajoutTest.html.twig', [
            'form'=>$form->createView()        
        ]);
    }

    /**
     * @Route("/listeTests", name="listeTests")
    */
    public function listeTests(Request $request)
    {
        $em = $this->getDoctrine();
        $repoTest = $em->getRepository(Test::class);
           
        if ($request->get('supp')!=null){
            $test = $repoTest->find($request->get('supp'));
            if($test!=null){
            $em->getManager()->remove($test);
            $em->getManager()->flush();
            }
            $this->addFlash('notice', 'Test supprimé');
            return $this->redirectToRoute('listeTests');
        } 
           

        $tests = $repoTest->findBy(array(),array('libelle'=>'ASC'));
        return $this->render('test/listeTests.html.twig', [
            'tests'=>$tests
        ]);
    }

    /**
     * @Route("/modifTest/{id}", name="modifTest", requirements={"id"="\d+"})
    */
    public function modifTest(int $id, request $request)
    {
        $em = $this->getDoctrine();
        $repoTest = $em->getRepository(Test::class);
        $test = $repoTest->find($id);
            if($test==null){
                $this->addFlash('notice', "Ce test n'existe pas");
                return $this->redirectToRoute('liste_tests');
            }
            $form = $this->createForm(ModifTestType::class,$test);
                if ($request->isMethod('POST')) {
                    $form->handleRequest($request);
                    if ($form->isSubmitted() && $form->isValid()) {
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($test);
                        $em->flush();
                        $this->addFlash('notice', 'Test modifié');
                    }   
                    return $this->redirectToRoute('listeTests');
                }

            return $this->render('test/modifTest.html.twig', [
                'form'=>$form->createView() 
        ]);
    }
}
