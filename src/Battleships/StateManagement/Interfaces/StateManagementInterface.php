<?php

namespace Battleships\StateManagement\Interfaces;

/**
 * Interface StateManagementInterface
 * @package AppBundle\StateManagement\Interfaces
 */
interface StateManagementInterface
{
    /**
     * @param $name
     * @param \Serializable $object
     * @return StateManagementInterface
     */
    public function persistObject($name, $object);

    /**
     * @param $name
     * @return bool
     */
    public function objectExists($name);

    /**
     * @param $name
     * @return mixed
     */
    public function getObject($name);

    /**
     * @param $name
     * @return StateManagementInterface
     */
    public function deleteObject($name);
}