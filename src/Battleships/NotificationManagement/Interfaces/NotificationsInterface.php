<?php

namespace Battleships\NotificationManagement\Interfaces;

/**
 * Interface NotificationsInterface
 * @package AppBundle\NotificationManagement
 */
interface NotificationsInterface
{
    /**
     * @param string $type
     * @param string $message
     * @return mixed
     */
    public function saveSuccessMessage(string $type, string $message) : NotificationsInterface;

    /**
     * @param string $type
     * @param string $message
     * @return mixed
     */
    public function saveErrorMessage(string $type, string $message) : NotificationsInterface;

    /**
     * @param string $type
     * @param string $message
     * @return mixed
     */
    public function saveNotificationMessage(string $type, string $message) : NotificationsInterface;

    /**
     * @return array
     */
    public function getMessages() : array;
}