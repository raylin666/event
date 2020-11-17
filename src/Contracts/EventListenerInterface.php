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
 * Interface EventListenerInterface
 * @package Raylin666\Event\Contracts
 */
interface EventListenerInterface
{
    /**
     * 设置事件
     * @param object $event
     * @return mixed
     */
    public function setEvent(object $event);

    /**
     * 获取事件
     * @return EventAbstract|null
     */
    public function getEvent(): ?EventAbstract;
}