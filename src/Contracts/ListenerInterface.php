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

/**
 * Interface ListenerInterface
 * @package Raylin666\EventDispatcher\Contracts
 */
interface ListenerInterface
{
    /**
     * @param object $event
     * @return mixed
     */
    public function process(object $event);
}