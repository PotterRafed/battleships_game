<?php

namespace Battleships\NotificationManagement\Adapters;

use Battleships\NotificationManagement\Interfaces\NotificationsInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class SessionNotificationManager
 * @package AppBundle\NotificationManagement\Adapters
 */
class SessionNotificationManager implements NotificationsInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * SessionNotificationManager constructor.
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param string $type
     * @param string $message
     *
     * @return NotificationsInterface
     */
    public function saveSuccessMessage(string $type, string $message) : NotificationsInterface
    {
        $this->addToFlashbag($type, $message);
        return $this;
    }

    /**
     * @param string $type
     * @param string $message
     * @return NotificationsInterface
     */
    public function saveErrorMessage(string $type, string $message) : NotificationsInterface
    {
        $this->addToFlashbag($type, $message);
        return $this;
    }

    /**
     * @param string $type
     * @param string $message
     * @return NotificationsInterface`
     */
    public function saveNotificationMessage(string $type, string $message) : NotificationsInterface
    {
        $this->addToFlashbag($type, $message);
        return $this;
    }

    /**
     * @param string $type
     * @param string $message
     * @return NotificationsInterface
     */
    private function addToFlashbag(string $type, string $message) : NotificationsInterface
    {
        $this->session->getFlashBag()->add($type, $message);
        return $this;
    }

    /**
     * @return array
     */
    public function getMessages() : array
    {
        return $this->session->getFlashBag()->all();
    }
}