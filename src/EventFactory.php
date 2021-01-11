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
use Raylin666\Util\Helper\ReflectionHelper;
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

    /**
     * 获取事件监听器
     * @return ListenerProviderInterface
     */
    public function listener(): ListenerProviderInterface
    {
        // TODO: Implement listener() method.

        return $this->listener;
    }

    /**
     * 获取事件发布器
     * @return EventDispatcherInterface
     */
    public function dispatcher(): EventDispatcherInterface
    {
        // TODO: Implement dispatcher() method.

        return $this->dispatcher;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \ReflectionException
     */
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.

        $eventDispatcher = ReflectionHelper::doClass(EventDispatcherInterface::class);
        if ($eventDispatcher->hasMethod($name)) {
            return $this->dispatcher->$name(...$arguments);
        }

        $listenerProvider = ReflectionHelper::doClass(ListenerProviderInterface::class);
        if ($listenerProvider->hasMethod($name)) {
            return $this->listener->$name(...$arguments);
        }
    }
}