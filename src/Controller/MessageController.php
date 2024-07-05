<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contact')]
class MessageController extends AbstractController
{
    #[Route('/messages', name: 'app_message_index', methods: ['GET'])]
    public function index(MessageRepository $messageRepository): Response
    {
        if ($this->getUser()) {
            return $this->render('message/index.html.twig', [
                'messages' => $messageRepository->findAll(),
            ]);
        }
        return $this->render('security/login.html.twig');
    }

    #[Route('/', name: 'app_message_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            $message = new Message();
            $form = $this->createForm(MessageType::class, $message);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($message);
                $entityManager->flush();
    
                return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
            }
    
            return $this->render('message/new.html.twig', [
                'message' => $message,
                'form' => $form,
            ]);
        }
        return $this->render('security/login.html.twig');
    }

    #[Route('/messages/{id}', name: 'app_message_show', methods: ['GET'])]
    public function show(Message $message): Response
    {
            if ($this->getUser()) {
                return $this->render('message/show.html.twig', [
                    'message' => $message,
                ]);
            }
            return $this->render('security/login.html.twig');
    }

    #[Route('/messages/{id}/edit', name: 'app_message_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_delete', methods: ['POST'])]
    public function delete(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
    }
}