<?php

namespace Battleships\Core;

use Battleships\Factory\GameBoardFactory;
use Battleships\Input\InputHandler;
use Battleships\NotificationManagement\GameNotificationManager;
use Battleships\Objects\ShotResult;
use Battleships\StateManagement\GameStateManager;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class Game
 * @package AppBundle\Battleships
 */
class Game
{
    const DISPLAY_MODE_NORMAL = 1;
    const DISPLAY_MODE_CHEAT = 2;

    const END_GAME_MESSAGE_TEMPLATE = "Congratulations! You have beaten the game using %s shots";

    /**
     * @var GameBoard
     */
    private $board;

    /**
     * @var GameStateManager
     */
    private $gameStateManager;

    /**
     * @var GameNotificationManager
     */
    private $gameNotificationManager;

    /**
     * @var InputHandler
     */
    private $inputHandler;

    /**
     * Game constructor.
     * @param GameBoardFactory $boardFactory
     * @param InputHandler $inputHandler
     * @param GameStateManager $gameStateManager
     * @param GameNotificationManager $gameNotificationManager
     */
    public function __construct(
        GameBoardFactory $boardFactory,
        InputHandler $inputHandler,
        GameStateManager $gameStateManager,
        GameNotificationManager $gameNotificationManager
    ) {
        $this->gameStateManager = $gameStateManager;
        $this->inputHandler = $inputHandler;
        $this->gameNotificationManager = $gameNotificationManager;

        if (true === $this->gameStateManager->isExistingGame()) {
            $this->board = $this->gameStateManager->getBoard();
        } else {
            $this->board = $boardFactory();
        }

        $this->saveGame();
    }

    /**
     * @return array
     */
    public function getPlayBoard()
    {
        $outputBoard = $this->board->generateOutputBoard();
        
        //Restore the game mode as cheat-mode is single-use only.
        $this->switchCheatMode(false);

        return $outputBoard;
    }

    /**
     * @param bool $switch
     */
    private function switchCheatMode(bool $switch)
    {
        $newDisplayMode = $switch ? self::DISPLAY_MODE_CHEAT : self::DISPLAY_MODE_NORMAL;

        //If the game is in a different display mode than requested - change it
        if ($this->board->getDisplayMode() != $newDisplayMode) {
            $this->board->setDisplayMode($newDisplayMode);
            $this->saveGame();
        }

        if ($newDisplayMode == Game::DISPLAY_MODE_CHEAT) {
            $this->gameNotificationManager->addNotification("Showing all ships...");
        }
    }

    /**
     * @param string $input
     */
    public function shootAt(string $input)
    {
        //Check if the input is a keyword to enable cheat mode
        if (true == $this->inputHandler->isCheatKeyword($input)) {
            $this->switchCheatMode(true);
            return;
        }
        try {
            $shootPoint = $this->inputHandler->getShootPoint($input);

            /** @var ShotResult $successfulShot */
            $shotResult = $this->board->shootAt($shootPoint);

            if (true == $shotResult->isSuccess()) {
                $this->gameNotificationManager->addSuccessMessage($shotResult->getMessage());

                //Check if game is over
                if (true == $this->board->checkIsGameOver()) {
                    $this->gameNotificationManager->addSuccessMessage(sprintf(
                        $this::END_GAME_MESSAGE_TEMPLATE,
                        $this->board->getNumberOfAttempts()
                    ));
                }
            } else {
                $this->gameNotificationManager->addErrorMessage($shotResult->getMessage());
            }

        } catch (\Exception $e) {
            $this->gameNotificationManager->addErrorMessage($e->getMessage());
        }

        $this->saveGame();
    }

    /**
     * @return array
     */
    public function getNotifications()
    {
        return $this->gameNotificationManager->getMessages();
    }

    /**
     * @return bool
     */
    public function isGameOver()
    {
        return $this->board->isGameOver();
    }

    /**
     * Saves the game
     */
    private function saveGame()
    {
        $this->gameStateManager->saveBoard($this->board);
    }

    /**
     * Starts a new game
     */
    public function newGame()
    {
        $this->gameStateManager->clearBoard();
    }
}