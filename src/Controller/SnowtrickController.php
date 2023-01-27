<?php

namespace App\Controller;

use App\Entity\Snowtrick;
use App\Form\SnowtrickType;
use App\Repository\SnowtrickRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use App\Service\FileUploader;

// #[Route('/snowtrick')]
class SnowtrickController extends AbstractController
{
    #[Route('/', name: 'app_snowtrick_index', methods: ['GET'])]
    public function index(SnowtrickRepository $snowtrickRepository): Response
    {
        return $this->render('snowtrick/index.html.twig', [
            'snowtricks' => $snowtrickRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_snowtrick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SnowtrickRepository $snowtrickRepository, UserRepository $userRepository, FileUploader $fileUploader): Response
    {
        $snowtrick = new Snowtrick();
        $form = $this->createForm(SnowtrickType::class, $snowtrick, ['validation_groups' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A modifier quand syst login user done
            $user = $userRepository->findOneById(1);
            $snowtrick->setUser($user);
            $snowtrick->setAuthor($user->getNickname().' '.$user->getName());

            $slugger = new AsciiSlugger();
            $snowtrick->setSlug(strtolower($slugger->slug($snowtrick->getTitle())));

            $fileUploader->uploadImages($snowtrick);

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

    #[Route('/{id}', name: 'app_snowtrick_show', methods: ['GET'])]
    public function show(Snowtrick $snowtrick): Response
    {
        return $this->render('snowtrick/show.html.twig', [
            'snowtrick' => $snowtrick,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_snowtrick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Snowtrick $snowtrick, SnowtrickRepository $snowtrickRepository/*, FileUploader $fileUploader */): Response
    {
        $form = $this->createForm(SnowtrickType::class, $snowtrick, ['validation_groups' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $snowtrickRepository->save($snowtrick, true);

            return $this->redirectToRoute('app_snowtrick_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('snowtrick/edit.html.twig', [
            'snowtrick' => $snowtrick,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_snowtrick_delete', methods: ['POST'])]
    public function delete(Request $request, Snowtrick $snowtrick, SnowtrickRepository $snowtrickRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$snowtrick->getId(), $request->request->get('_token'))) {
            $snowtrickRepository->remove($snowtrick, true);
        }

        return $this->redirectToRoute('app_snowtrick_index', [], Response::HTTP_SEE_OTHER);
    }
}
