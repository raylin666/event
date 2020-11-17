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

use Raylin666\Event\Contracts\EventHandleInterface;
use Raylin666\Event\Contracts\EventInterface;
use Raylin666\Event\Contracts\EventRegisterInterface;

/**
 * Class Event
 * @package Raylin666\Event
 */
class Event implements EventInterface
{
    /**
     * @var array
     */
    private $register = [];

    /**
     * @var array
     */
    private $events = [];

    /**
     * Event constructor.
     * @param EventRegisterInterface $eventRegister
     */
    public function __construct(EventRegisterInterface $eventRegister)
    {
        $this->register = $eventRegister->events();
    }

    /**
     * @param string                $event
     * @param callable              $callback
     * @return EventInterface
     */
    public function add(string $event, callable $callback): EventInterface
    {
        // TODO: Implement add() method.

        if (in_array($event, $this->register)) {
            $this->events[$event][] = $callback;
        }

        return $this;
    }

    /**
     * @param string $event
     * @return bool
     */
    public function has(string $event): bool
    {
        // TODO: Implement has() method.

        return isset($this->events[$event]) ? true : false;
    }

    /**
     * @param string $event
     * @return array|null
     */
    public function get(string $event): ?array
    {
        // TODO: Implement get() method.

        return isset($this->events[$event]) ? $this->events[$event] : null;
    }

    /**
     * @param string $event
     * @return EventInterface
     */
    public function del(string $event): EventInterface
    {
        // TODO: Implement del() method.

        unset($this->events[$event]);

        return $this;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        // TODO: Implement all() method.

        return $this->events;
    }

    /**
     * @return mixed|void
     */
    public function clear()
    {
        // TODO: Implement clear() method.

        $this->events = [];
    }
}