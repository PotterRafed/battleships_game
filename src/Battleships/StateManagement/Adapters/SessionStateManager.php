<?php

namespace Battleships\StateManagement\Adapters;

use Battleships\StateManagement\Interfaces\StateManagementInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class SessionStateManager
 * @package AppBundle\StateManagement\Adapters
 */
class SessionStateManager implements StateManagementInterface
{
    /** @var Session */
    private $session;

    /**
     * SessionStateManager constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getObject($name)
    {
        return unserialize($this->session->get($name));
    }

    /**
     * @param $name
     * @return bool
     */
    public function objectExists($name)
    {
        return $this->session->has($name);
    }

    /**
     * @param $name
     * @param \Serializable $object
     * @return StateManagementInterface
     */
    public function persistObject($name, $object)
    {
        $this->session->set($name, serialize($object));
        return $this;
    }

    /**
     * @param $name
     * @return StateManagementInterface
     */
    public function deleteObject($name)
    {
        $this->session->remove($name);
        return $this;
    }
}