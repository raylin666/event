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

use Raylin666\Event\Contracts\EventRegisterInterface;

/**
 * Class EventRegister
 * @package Raylin666\Event
 */
class EventRegister implements EventRegisterInterface
{
    /**
     * @var array
     */
    protected $events = [];

    /**
     * EventRegister constructor.
     * @param array $events
     */
    public function __construct(array $events)
    {
        $this->events = $events;
    }

    /**
     * @return array
     */
    public function returnEventNames(): array
    {
        // TODO: Implement returnEventNames() method.

        return $this->events;
    }
}