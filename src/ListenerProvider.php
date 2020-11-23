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

use Raylin666\Core\Helper\ArrayHelper;
use Raylin666\EventDispatcher\Contracts\EventInterface;
use Raylin666\EventDispatcher\Contracts\ListenerProviderInterface;
use Raylin666\EventDispatcher\Contracts\SubscriberInterface;
use SplPriorityQueue;

/**
 * Class ListenerProvider
 * @package Raylin666\EventDispatcher
 */
class ListenerProvider implements ListenerProviderInterface
{
    /**
     * @var EventRegister[]
     */
    protected $listeners = [];

    /**
     * @return EventRegister[]
     */
    public function getListeners(): array
    {
        return $this->listeners;
    }

    /**
     * @param object $event
     * @return iterable
     */
    public function getListenersForEvent(object $event): iterable
    {
        // TODO: Implement getListenersForEvent() method.

        // 优先级队列处理
        $queue = new SplPriorityQueue();

        if (($event instanceof EventInterface)
            && ($listeners = $this->getEventAllListeners($event->getName()))
        ) {
            foreach ($listeners as $listener) {
                $queue->insert($listener->getListener(), $listener->getPriority());
            }
        }

        return $queue;
    }

    /**
     * @param string $event
     * @param        $listener
     * @param int    $priority
     * @return mixed|void
     */
    public function addListener(string $event, $listener, int $priority = 1)
    {
        // TODO: Implement addListener() method.

        $this->listeners[$event][] = new EventRegister($event, $listener, $priority);
    }

    public function addSubscriber(SubscriberInterface $subscriber)
    {
        // TODO: Implement addSubscriber() method.
    }

    /**
     * @return array
     */
    public function getEventNames(): array
    {
        return array_keys($this->listeners);
    }

    /**
     * @param string $eventName
     * @return bool
     */
    public function hasEvent(string $eventName): bool
    {
        return isset($this->listeners[$eventName]);
    }

    /**
     * @param string $eventName
     */
    public function delEvent(string $eventName)
    {
        ArrayHelper::forget($this->listeners, $eventName);
    }

    /**
     * @param string $eventName
     * @return array
     */
    public function getEventAllListeners(string $eventName): array
    {
        return ArrayHelper::get($this->listeners, $eventName) ? : [];
    }

    /**
     * Clear All Listeners
     */
    public function clearAllListeners()
    {
        $this->listeners = [];
    }
}