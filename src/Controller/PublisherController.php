<?php

namespace App\Controller;

use Exception;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublisherController extends AbstractController
{
    #[Route('/', name: 'app_publisher', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('publisher/index.html.twig', [
            'controller_name' => 'PublisherController',
        ]);
    }

    #[Route('/', name: 'app_publisher_submit', methods: ['POST'])]
    public function test(Request $request, ProducerInterface $taskProducer): Response
    {
        try {
            $msg = $request->get('message');
            $taskProducer->publish(json_encode($msg));
        } catch (Exception $ex) {
            $this->addFlash('danger', 'Errore durante l\'invio con messaggio: ' . $ex->getMessage());
        }
        return $this->redirectToRoute('app_publisher');
    }
}
