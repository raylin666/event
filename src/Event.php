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

namespace Raylin666\EventDispatcher;

use Psr\EventDispatcher\StoppableEventInterface;
use Raylin666\Contract\EventInterface;
use Serializable;

/**
 * Class Event
 * @package Raylin666\EventDispatcher
 */
abstract class Event implements EventInterface, StoppableEventInterface, Serializable
{
    /**
     * 事件是否需要执行, 为 true 时 不执行该事件绑定的所有监听
     * @return bool
     */
    public function isPropagationStopped(): bool
    {
        // TODO: Implement isPropagationStopped() method.

        return false;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.

        return serialize($this);
    }

    /**
     * @param string $serialized
     * @return mixed|void
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.

        return unserialize($serialized);
    }
}