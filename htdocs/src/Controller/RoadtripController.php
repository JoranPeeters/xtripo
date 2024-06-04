<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RoadtripController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(/*EntityManagerInterface $entityManager, Security $security*/)
    {
        // $this->entityManager = $entityManager;
        // $this->security = $security;
    }

    #[Route('/roadtrip/{id}', name: 'app_roadtrip_view')]
    public function view(int $id): Response
    {
        // $roadtrip = $this->entityManager->getRepository(Roadtrip::class)->find($id);

        // if (!$roadtrip) {
        //     throw $this->createNotFoundException('The roadtrip does not exist');
        // }

        // if ($roadtrip->getUser() !== $this->getUser()) {
        //     throw new AccessDeniedHttpException('You do not have access to this roadtrip');
        // }

        return $this->render('roadtrip/index.html.twig', [
            // 'roadtrip' => $roadtrip,
        ]);
    }
}