<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Certification;

class CertificationController extends AbstractController
{
    /**
     * @Route("/listeCertifications", name="listeCertifications")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine();
        $repoCertification = $em->getRepository(Certification::class);
        $getCertifications = $repoCertification->getNbTests();

        return $this->render('certification/listeCertifications.html.twig', [
            'certifications'=>$getCertifications
        ]);
    }
}
