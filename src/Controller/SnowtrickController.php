<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Snowtrick;
use App\Entity\ChatMessage;
use App\Form\SnowtrickType;
use App\Form\ChatMessageType;
use App\Service\FileUploader;
use Doctrine\ORM\Mapping\Entity;
use App\Service\FormInputHandler;
use App\Repository\UserRepository;
use App\Repository\SnowtrickRepository;
use App\Repository\ChatMessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SnowtrickController extends AbstractController
{
    #[Route('/', name: 'app_snowtrick_index', methods: ['GET'])]
    public function index(SnowtrickRepository $snowtrickRepository): Response
    {
        return $this->render('snowtrick/index.html.twig', [
            'snowtricks' => $snowtrickRepository->findAll(),
        ]);
    }

    #[Route('/snowtrick/new', name: 'app_snowtrick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SnowtrickRepository $snowtrickRepository, FileUploader $fileUploader, FormInputHandler $formInputHandler): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $snowtrick = new Snowtrick();
        $form = $this->createForm(SnowtrickType::class, $snowtrick, ['validation_groups' => 'new', 'button_label' => 'Créer la figure']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formInputHandler->trickCreateVerification($snowtrick);

            $snowtrick->setUser($user);
            $snowtrick->setAuthor($user->getNickname().' '.$user->getName());

            $slugger = new AsciiSlugger();
            $snowtrick->setSlug(strtolower($slugger->slug($snowtrick->getTitle())));

            $fileUploader->uploadImages($snowtrick);
            $fileUploader->uploadVideos($snowtrick);

            $snowtrickRepository->save($snowtrick, true);

            $this->addFlash(
                'success',
                'Votre figure a bien été crée.'
            );

            return $this->redirectToRoute('app_snowtrick_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('snowtrick/new.html.twig', [
            'snowtrick' => $snowtrick,
            'form' => $form,
        ]);
    }

    #[Route('/snowtrick/show/{id}/{slug}', name: 'app_snowtrick_show', methods: ['GET', 'POST'])]
    public function show(Request $request,  Snowtrick $snowtrick, ChatMessageRepository $chatMessageRepository): Response
    {
        $chatMessage = new ChatMessage();
        $chatMessageForm = $this->createForm(ChatMessageType::class, $chatMessage);
        $chatMessageForm->handleRequest($request);

        $chatMessages = $chatMessageRepository->findBy(array('snowtrick' => $snowtrick->getId()),array('creationDate' => 'DESC'));

        if ($chatMessageForm->isSubmitted() && $chatMessageForm->isValid()) {
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $chatMessage->setUser($user);

            $chatMessage->setSnowtrick($snowtrick);
            $chatMessageRepository->save($chatMessage, true);

            $this->addFlash(
                'success',
                'Votre message a bien été envoyé au chat.'
            );

            return $this->redirectToRoute('app_snowtrick_show', ['slug' => $snowtrick->getSlug(), 'id' => $snowtrick->getId()], Response::HTTP_SEE_OTHER);
        } elseif ($chatMessageForm->isSubmitted() && !$chatMessageForm->isValid()) {
            $this->addFlash(
                'danger',
                'Votre message n\'a pas été envoyé.'
            );

            return $this->redirectToRoute('app_snowtrick_show', ['slug' => $snowtrick->getSlug(), 'id' => $snowtrick->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('snowtrick/show.html.twig', [
            'snowtrick' => $snowtrick,
            'pictures' => $snowtrick->getPictures(),
            'chatMessages' => $chatMessages,
            'chatMessageForm' => $chatMessageForm
        ]);
    }

    #[Route('/snowtrick/edit/{id}', name: 'app_snowtrick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Snowtrick $snowtrick, SnowtrickRepository $snowtrickRepository, FileUploader $fileUploader, FormInputHandler $formInputHandler): Response
    {
        $this->denyAccessUnlessGranted('edit', $snowtrick);

        $form = $this->createForm(SnowtrickType::class, $snowtrick, ['validation_groups' => 'edit', 'button_label' => 'Modifier']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formInputHandler->trickCreateVerification($snowtrick);

            $slugger = new AsciiSlugger();
            $snowtrick->setSlug(strtolower($slugger->slug($snowtrick->getTitle())));

            $modifDate = new \DateTimeImmutable();
            $snowtrick->setModificationDate($modifDate);
            $fileUploader->uploadImages($snowtrick);
            $fileUploader->uploadVideos($snowtrick);

            $snowtrickRepository->save($snowtrick, true);

            $this->addFlash(
                'success',
                'Votre figure a bien été modifié.'
            );

            return $this->redirectToRoute('app_snowtrick_show', ['slug' => $snowtrick->getSlug(), 'id' => $snowtrick->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('snowtrick/edit.html.twig', [
            'snowtrick' => $snowtrick,
            'form' => $form,
        ]);
    }

    #[Route('/snowtrick/delete/{id}', name: 'app_snowtrick_delete', methods: ['POST'])]
    public function delete(Request $request, Snowtrick $snowtrick, SnowtrickRepository $snowtrickRepository): Response
    {
        $this->denyAccessUnlessGranted('delete', $snowtrick);

        if ($this->isCsrfTokenValid('delete'.$snowtrick->getId(), $request->request->get('_token'))) {
            $snowtrickRepository->remove($snowtrick, true);
        }

        return $this->redirectToRoute('app_snowtrick_index', [], Response::HTTP_SEE_OTHER);
    }
}
