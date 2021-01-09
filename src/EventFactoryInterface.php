<?php
// +----------------------------------------------------------------------
// | Created by linshan. 版权所有 @
// +----------------------------------------------------------------------
// | Copyright (c) 2019 All rights reserved.
// +----------------------------------------------------------------------
// | Technology changes the world . Accumulation makes people grow .
// +----------------------------------------------------------------------
// | Author: kaka梦很美 <1099013371@qq.com>
// +----------------------------------------------------------------------

namespace Raylin666\Event;

use Raylin666\Contract\FactoryInterface;
use Raylin666\Contract\EventDispatcherInterface;
use Raylin666\Contract\ListenerProviderInterface;

/**
 * Interface EventFactoryInterface
 * @package Raylin666\Event
 */
interface EventFactoryInterface extends FactoryInterface
{
    /**
     * @return ListenerProviderInterface
     */
    public function listener(): ListenerProviderInterface;

    /**
     * @return EventDispatcherInterface
     */
    public function dispatcher(): EventDispatcherInterface;
}