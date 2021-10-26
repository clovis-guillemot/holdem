<?php

namespace App\Controller;

use App\Entity\GameType;
use App\Entity\PokerHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HoldemController extends AbstractController
{

    /**
    * @Route("/", name = "holdem")
    */
    public function new(Request $request): Response
    {
        $form = $this->createForm(GameType::class);

        $form->handleRequest($request);
        $winner = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();
            $handA = new PokerHand($game['handA']);
            $handB = new PokerHand($game['handB']);
            $result = $handA->compareWith($handB->hand);
            if ($result == 1) {
                $winner = 'First Hand';
            } else if ($result == 2) {
                $winner = 'Second Hand';
            } else if ($result == 3) {
                $winner = 'Tie';
            }
        }

        return $this->renderForm('holdem/form.html.twig', [
            'form' => $form,
            'winner' => $winner
        ]);
    }

}