<?php

namespace Battleships\StateManagement;

use Battleships\Core\GameBoard;
use Battleships\StateManagement\Interfaces\StateManagementInterface;

/**
 * Class GameStateManager
 * @package AppBundle\StateManagement
 */
class GameStateManager
{
    const GAME_OBJECT_NAME = 'board';

    /** @var StateManagementInterface $stateManager */
    private $stateManager;

    /**
     * GameStateManager constructor.
     * @param StateManagementInterface $stateManager
     */
    public function __construct(StateManagementInterface $stateManager)
    {
        $this->stateManager = $stateManager;
    }

    /**
     * @return bool
     */
    public function isExistingGame()
    {
        return $this->stateManager->objectExists($this::GAME_OBJECT_NAME);
    }

    /**
     * @return mixed
     */
    public function getBoard() : GameBoard
    {
        return $this->stateManager->getObject($this::GAME_OBJECT_NAME);
    }

    /**
     * @param $board
     */
    public function saveBoard($board)
    {
        $this->stateManager->persistObject($this::GAME_OBJECT_NAME, $board);
    }

    /**
     * Clears the board from state
     */
    public function clearBoard()
    {
        $this->stateManager->deleteObject($this::GAME_OBJECT_NAME);
    }
}