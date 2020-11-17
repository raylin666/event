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

namespace Raylin666\Event\Contracts;

/**
 * Class ListenerAbstract
 * @package Raylin666\Event\Contracts
 */
abstract class ListenerAbstract implements EventListenerInterface
{
    /**
     * @var
     */
    protected $event;

    /**
     * @param object $event
     * @return mixed
     */
    abstract function handle(object $event);

    /**
     * @param object $event
     * @return mixed|void
     */
    final public function setEvent(object $event)
    {
        // TODO: Implement setEvent() method.

        $this->event = $event;
    }

    /**
     * @return EventAbstract|null
     */
    final public function getEvent(): ?EventAbstract
    {
        // TODO: Implement getEvent() method.

        return $this->event;
    }
}