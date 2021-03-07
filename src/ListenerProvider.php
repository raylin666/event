<?php /** @noinspection ALL */
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

use Closure;
use SplPriorityQueue;
use InvalidArgumentException;
use Raylin666\Contract\EventInterface;
use Raylin666\Contract\EventRegisterInterface;
use Raylin666\Contract\ListenerProviderInterface;
use Raylin666\Contract\SubscriberInterface;

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
     * @param object $event
     * @return iterable
     */
    public function getListenersForEvent(object $event): iterable
    {
        // TODO: Implement getListenersForEvent() method.

        // 优先级队列处理
        $queue = new SplPriorityQueue();

        if (($event instanceof EventInterface)
            && ($listeners = $this->getEventListener($event->getEventAccessor()))
        ) {
            foreach ($listeners as $listener) {
                if ($listener instanceof EventRegisterInterface) {
                    $queue->insert($listener->getListener(), $listener->getPriority());
                }
            }
        }

        return $queue;
    }

    /**
     * Get the subscriber register closure.
     * @param SubscriberInterface $subscriber
     * @throws InvalidArgumentException
     * @return Closure
     */
    private function getSubscriberRegister(SubscriberInterface $subscriber): Closure
    {
        $closure = function ($event, ...$methods) use ($subscriber) {
            foreach ($methods as $value) {
                switch (true) {
                    case is_string($value):
                        $method = $value;
                        $priority = 1;
                        break;
                    case is_array($value):
                        $method = $value[0];
                        $priority = $value[1] ?? 1;
                        break;
                    default:
                        throw new InvalidArgumentException('method parameters only accepts string or array.');
                }

                $this->addListener($event, [$subscriber, $method], $priority);
            }
        };

        return $closure->bindTo($this);
    }

    /**
     * 添加监听
     * @param string $event
     * @param        $listener
     * @param int    $priority
     * @return mixed|void
     */
    public function addListener(string $event, $listener, int $priority = 1)
    {
        // TODO: Implement addListener() method.

        $this->listeners[$event][] = make(
            EventRegister::class,
            [
                'event'     =>  $event,
                'listener'  =>  $listener,
                'priority'  =>  $priority
            ]
        );
    }

    /**
     * 添加订阅
     * @param SubscriberInterface $subscriber
     * @return mixed|void
     */
    public function addSubscriber(SubscriberInterface $subscriber)
    {
        // TODO: Implement addSubscriber() method.

        $closure = $this->getSubscriberRegister($subscriber);
        $subscriber->subscribe($closure);
    }

    /**
     * @return EventRegister[]
     */
    public function getEventListeners(): array
    {
        return $this->listeners;
    }

    /**
     * @param string $event
     * @return array
     */
    public function getEventListener(string $event): array
    {
        return $this->listeners[$event] ?? [];
    }

    /**
     * @param string $event
     * @return bool
     */
    public function hasEventListener(string $event): bool
    {
        return array_key_exists($event, $this->listeners);
    }

    /**
     * @param string $event
     */
    public function deleteEventListener(string $event)
    {
        unset($this->listeners[$event]);
    }

    /**
     * Clear All Listeners
     */
    public function clearEventListeners()
    {
        $this->listeners = [];
    }
}