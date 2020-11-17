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

namespace Raylin666\Event\Contracts;

/**
 * Interface EventInterface
 * @package Raylin666\Event\Contracts
 */
interface EventInterface
{
    /**
     * EventInterface constructor.
     * @param EventRegisterInterface $eventRegister
     */
    public function __construct(EventRegisterInterface $eventRegister);

    /**
     * 添加事件回调 (单个事件可以添加N个回调方法) 通过N个事件可以实现分发到事件群实现统一注册
     * @param string                $event
     * @param callable              $callback
     * @return EventInterface
     */
    public function add(string $event, callable $callback): EventInterface;

    /**
     * 事件是否有注册(是否已存在)
     * @param string $event
     * @return bool
     */
    public function has(string $event): bool;

    /**
     * 删除事件
     * @param string $event
     * @return EventInterface
     */
    public function del(string $event): EventInterface;

    /**
     * 获取指定事件
     * @param string $event
     * @return array|null
     */
    public function get(string $event): ?array;

    /**
     * 获取所有事件
     * @return array
     */
    public function all(): array;

    /**
     * 清除事件为初始状态
     * @return mixed
     */
    public function clear();
}