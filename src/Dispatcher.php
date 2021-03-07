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

use TypeError;
use Exception;
use Raylin666\Contract\EventInterface;
use Raylin666\Contract\EventDispatcherInterface;
use Raylin666\Contract\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Class Dispatcher
 * @package Raylin666\EventDispatcher
 */
class Dispatcher implements EventDispatcherInterface
{
    /**
     * @var ListenerProviderInterface
     */
    protected $listenerProvider;

    /**
     * @param ListenerProviderInterface $listenerProvider
     */
    public function __invoke(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }

    /**
     * @return ListenerProviderInterface
     */
    public function getListenerProvider(): ListenerProviderInterface
    {
        return $this->listenerProvider;
    }

    /**
     * @param object $event
     * @return object
     */
    public function dispatch(object $event)
    {
        // TODO: Implement dispatch() method.

        if (! $event instanceof EventInterface) {
            throw new TypeError('The named event must implement \Raylin666\Contract\EventInterface.');
        }

        if (! $this->listenerProvider instanceof ListenerProviderInterface) {
            throw new Exception('Be sure to set the listener provider class.');
        }

        if ($this->isEventPropagationStopped($event)) {
            return $event;
        }

        foreach ($this->getListenerProvider()->getListenersForEvent($event) as $listener) {
            if (is_object($listener) || is_callable($listener) || is_array($listener)) {
                if (is_array($listener)) {
                    if (count($listener) > 2) {
                        // 处理$listener格式类似 [$onStart, 'event', [1, 'raylin', function () {}]]
                        $listener[2] && is_array($listener[2]) ?
                            ([$listener[0], $listener[1]])($event, ...$listener[2])
                            : ([$listener[0], $listener[1]])($event, $listener[2]);
                    } else {
                        is_string($listener[0]) ?
                            ([new $listener[0], $listener[1]])($event)
                            : $listener($event);
                    }
                } else {
                    $listener($event);
                }

                if ($this->isEventPropagationStopped($event)) {
                    break;
                }

                continue ;
            }
        }

        return $event;
    }

    /**
     * @param object $event
     * @return bool
     */
    protected function isEventPropagationStopped(object $event): bool
    {
        return (
            $event instanceof StoppableEventInterface
            && $event->isPropagationStopped()
        );
    }
}