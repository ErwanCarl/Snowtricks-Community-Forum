<?php

namespace App\Service;

use App\Entity\Snowtrick;
use App\Form\LostPasswordType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormInputHandler extends AbstractController
{
    public function trickCreateVerification(Snowtrick $snowtrick)
    {
        if($snowtrick->getTitle() === null) {
            $this->addFlash(
                'danger',
                'Vous devez rentrer un titre.'
            );
            return $this->redirectToRoute('app_snowtrick_new', [], Response::HTTP_SEE_OTHER);
        } elseif($snowtrick->getContent() === null) {
            $this->addFlash(
                'danger',
                'Vous devez rentrez un contenu.'
            );
            return $this->redirectToRoute('app_snowtrick_new', [], Response::HTTP_SEE_OTHER);
        } elseif($snowtrick->getTrickGroup() === null) {
            $this->addFlash(
                'danger',
                'Vous devez assigner un groupe à la figure.'
            );
            return $this->redirectToRoute('app_snowtrick_new', [], Response::HTTP_SEE_OTHER);
        }
    }
}
