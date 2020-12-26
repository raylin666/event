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

use Psr\EventDispatcher\EventDispatcherInterface;
use Raylin666\Contract\FactoryInterface;
use Psr\Container\ContainerInterface;
use Raylin666\Contract\ListenerProviderInterface;

/**
 * Class EventDispatcherFactory
 * @package Raylin666\EventDispatcher
 */
class EventDispatcherFactory implements FactoryInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     * @return FactoryInterface
     */
    public function __invoke(ContainerInterface $container): FactoryInterface
    {
        // TODO: Implement __invoke() method.

        $this->container = $container;
        return $this;
    }

    /**
     * @return EventDispatcherInterface
     */
    public function make(): EventDispatcherInterface
    {
        return new EventDispatcher(
            $this->container->get(ListenerProviderInterface::class)
        );
    }
}