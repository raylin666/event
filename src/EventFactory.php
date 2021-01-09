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

use Psr\Container\ContainerInterface;
use Raylin666\Contract\EventDispatcherInterface;
use Raylin666\Contract\ListenerProviderInterface;

/**
 * Class EventFactory
 * @package Raylin666\Event
 */
class EventFactory implements EventFactoryInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ListenerProviderInterface
     */
    protected $listener;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * EventFactory constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        // TODO: Implement __construct() method.

        $this->container = $container;
        $this->listener = $container->get(ListenerProviderInterface::class);
        $this->dispatcher = make(
            EventDispatcherInterface::class,
            [
                'listenerProvider'  =>  $this->listener
            ]
        );
    }
}