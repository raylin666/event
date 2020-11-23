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

namespace Raylin666\EventDispatcher\Contracts;

use Closure;

/**
 * Interface SubscriberInterface
 * @package Raylin666\EventDispatcher\Contracts
 */
interface SubscriberInterface
{
    /**
     * Register the subscriber for each event.
     * @param Closure $subscriber   [eventId => [mathod, priority]][]
     * @return mixed
     */
    public function subscribe(Closure $subscriber);
}