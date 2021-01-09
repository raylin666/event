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

use Raylin666\Contract\EventRegisterInterface;

/**
 * Class EventRegister
 * @package Raylin666\Event
 */
class EventRegister implements EventRegisterInterface
{
    /**
     * @var string
     */
    protected $event;

    /**
     * @var
     */
    protected $listener;

    /**
     * @var int
     */
    protected $priority;

    /**
     * EventRegister constructor.
     * @param string $event
     * @param        $listener
     * @param int    $priority
     */
    public function __construct(string $event, $listener, int $priority)
    {
        $this->event = $event;
        $this->listener = $listener;
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        // TODO: Implement getEvent() method.

        return $this->event;
    }

    /**
     * @return mixed
     */
    public function getListener()
    {
        // TODO: Implement getListener() method.

        return $this->listener;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        // TODO: Implement getPriority() method.

        return $this->priority;
    }
}
