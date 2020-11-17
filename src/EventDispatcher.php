<?php
// +----------------------------------------------------------------------
// | Created by linshan. 版权所有 @
// +----------------------------------------------------------------------
// | Copyright (c) 2020 All rights reserved.
// +----------------------------------------------------------------------
// | Technology changes the world . Accumulation makes people grow .
// +----------------------------------------------------------------------
// | Author: kaka梦很美 <1099013371@qq.com>
// +----------------------------------------------------------------------

namespace Raylin666\Event;

use Raylin666\Core\Helper\ObjectHelper;
use Raylin666\Event\Contracts\EventDispatcherInterface;

/**
 * Class EventDispatcher
 * @package Raylin666\Event
 */
class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array
     */
    private $events = [];

    /**
     * @param object $event
     * @return object|void
     */
    public function dispatch(object $event)
    {
        // TODO: Implement dispatch() method.

        $this->events[ObjectHelper::getReflectionClass($event)->getName()] = $event;
    }

    /**
     * @return array
     */
    public function getAllDispatch(): array
    {
        return $this->events;
    }

    /**
     * @return array
     */
    public function getAllDispatchNames(): array
    {
        return array_keys($this->events);
    }

    /**
     * @param string $event_name
     * @return bool
     */
    public function hasDispatch(string $event_name): bool
    {
        return isset($this->events[$event_name]) ? true : false;
    }

    /**
     * @param string $event_name
     * @return mixed|null
     */
    public function getDispatch(string $event_name)
    {
        return isset($this->events[$event_name]) ? $this->events[$event_name] : null;
    }

    /**
     * @param string $event_name
     */
    public function removeDispatch(string $event_name)
    {
        unset($this->events[$event_name]);
    }

    /**
     * clear all dispatch
     */
    public function clearAllDispatch()
    {
        $this->events = [];
    }
}