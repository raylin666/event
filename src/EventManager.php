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

use Error;
use Throwable;
use Raylin666\Core\Helper\ObjectHelper;
use Raylin666\Event\Contracts\EventAbstract;
use Raylin666\Event\Contracts\EventListenerInterface;

/**
 * Class EventManager
 * @package Raylin666\Event
 */
class EventManager
{
    /**
     * @var Event
     */
    protected $event;

    /**
     * EventManager constructor.
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * 获取事件名称
     * @return array
     */
    public function getEvents(): array
    {
        return array_keys($this->event->all());
    }

    /**
     * 获取事件及相关监听器
     * @return array
     */
    public function getEventAndListeners(): array
    {
        return $this->event->all();
    }

    /**
     * 事件是否存在
     * @param string $event
     * @return bool
     */
    public function hasEvent(string $event): bool
    {
        return $this->event->has($event);
    }

    /**
     * 删除事件
     * @param string $event
     * @return Event
     */
    public function delEvent(string $event): Event
    {
        return $this->event->del($event);
    }

    /**
     * 清理所有事件及相关监听器
     * @return mixed|void
     */
    public function clearEventAndListeners()
    {
        return $this->event->clear();
    }

    /**
     * 添加事件监听器
     * @param string $event
     * @param array  $listener
     */
    public function addListener(string $event, array $listener)
    {
        $this->event->add($event, function () use ($listener) {
            return $listener;
        });
    }

    /**
     * 获取事件监听器
     * @param string $event
     * @return array
     */
    public function getListeners(string $event): array
    {
        $listeners = [];
        foreach ($this->event->get($event) as $item) {
            $listeners = array_merge($listeners, call($item));
        }

        return $listeners;
    }

    /**
     * 事件触发器
     * @param EventAbstract $event
     * @throws \ReflectionException
     */
    public function trigger(EventAbstract $event)
    {
        $eventReflectionClass = ObjectHelper::getReflectionClass($event);
        $listeners = $this->getListeners($eventReflectionClass->getName());
        foreach ($listeners as $listener) {
            $this->handleListener($event, $listener);
        }
    }

    /**
     * 处理监听器
     * @param string $event
     * @param        $listener
     */
    protected function handleListener($event, $listener)
    {
        if (is_null($listener)) {
            return null;
        }

        if (is_callable($listener)) {
            try {
                // 回调函数不允许带其它参数,只注入回调事件
                call($listener, [$event]);
            } catch (Throwable $error) {}
        } else if (is_string($listener)) {
            if (class_exists($listener)) {
                $class = new $listener;
                if (($class instanceof EventListenerInterface) && method_exists($class, 'handle')) {
                    try {
                        // 只处理 handle 依赖注入的 $event 方法
                        $class->setEvent($event);
                        $class->handle($event);
                    } catch (Error $error) {}
                }
            }
        }
    }
}