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

use Psr\EventDispatcher\ListenerProviderInterface as PsrListenerProviderInterface;

/**
 * Interface ListenerProviderInterface
 * @package Raylin666\EventDispatcher\Contracts
 */
interface ListenerProviderInterface extends PsrListenerProviderInterface
{
    /**
     * @param string $event
     * @param        $listener
     * @param int    $priority
     * @return mixed
     */
    public function addListener(string $event, $listener, int $priority = 1);

    /**
     * @param SubscriberInterface $subscriber
     * @return mixed
     */
    public function addSubscriber(SubscriberInterface $subscriber);
}