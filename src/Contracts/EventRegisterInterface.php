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
 * Interface EventRegisterInterface
 * @package Raylin666\Event\Contracts
 */
interface EventRegisterInterface
{
    /**
     * 返回注册事件名称
     * @return array
     */
    public function returnEventNames(): array;
}