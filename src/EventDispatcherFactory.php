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

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Raylin666\EventDispatcher\Contracts\ListenerProviderInterface;

/**
 * Class EventDispatcherFactory
 * @package Raylin666\EventDispatcher
 */
class EventDispatcherFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $eventDispatcher
     * @return EventDispatcherInterface
     */
    public function __invoke(ContainerInterface $container, string $eventDispatcher = EventDispatcher::class): EventDispatcherInterface
    {
        // TODO: Implement __invoke() method.

        return new $eventDispatcher(
            $container->get(ListenerProviderInterface::class)
        );
    }
}