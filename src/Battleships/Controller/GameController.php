<?php

namespace Battleships\Controller;

use Battleships\Exception\BattleshipsException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends Controller
{
    /**
     * @Route("/", name="game_home")
     */
    public function defaultAction()
    {
        try {
            /** @var \Battleships\Core\Game */
            $game = $this->get('game');

        } catch (BattleshipsException $e) {
            die($e->getMessage());
        }

        return $this->render('Battleships::game.html.twig', array(
            'gameOver' => $game->isGameOver(),
            'board' => $game->getPlayBoard(),
            'notifications' => $game->getNotifications()
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     *
     * @Route("/shoot", name="game_shoot")
     */
    public function shotAction(Request $request)
    {
        if ($request->getMethod() !== 'POST') {
            return $this->redirectToRoute("game_home");
        }
        $input = $request->request->get('field');

        /** @var \Battleships\Core\Game */
        $game = $this->get('game');

        $game->shootAt($input);

        return $this->redirectToRoute("game_home");
    }

    /**
     * @Route("/newgame", name="new_game")
     */
    public function newGameAction()
    {
        /** @var \Battleships\Core\Game */
        $game = $this->get('game');

        $game->newGame();

        return $this->redirectToRoute("game_home");
    }

}