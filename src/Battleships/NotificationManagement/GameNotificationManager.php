<?php

namespace Battleships\NotificationManagement;

use Battleships\NotificationManagement\Interfaces\NotificationsInterface;

class GameNotificationManager
{
    const SUCCESS_MESSAGE_TYPE = 'success';
    const ERROR_MESSAGE_TYPE = 'error';
    const NOTIFICATION_MESSAGE_TYPE = 'notify';

    private $notificationsManager;

    public function __construct(NotificationsInterface $notificationsManager)
    {
        $this->notificationsManager = $notificationsManager;
    }

    public function addSuccessMessage($message)
    {
        $this->notificationsManager->saveSuccessMessage($this::SUCCESS_MESSAGE_TYPE, $message);
    }

    public function addErrorMessage($message)
    {
        $this->notificationsManager->saveErrorMessage($this::ERROR_MESSAGE_TYPE, $message);
    }

    public function addNotification($message)
    {
        $this->notificationsManager->saveNotificationMessage($this::NOTIFICATION_MESSAGE_TYPE, $message);
    }

    public function getMessages()
    {
        return $this->notificationsManager->getMessages();
    }
}