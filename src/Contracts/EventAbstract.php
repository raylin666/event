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
 * Class EventAbstract
 * @package Raylin666\Event\Contracts
 */
abstract class EventAbstract
{
    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value): self
    {
       $this->$name = $value;
       return $this;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $prefix = strtolower(substr($name, 0, 3));
        if (in_array($prefix, ['set', 'get'])) {
            $propertyName = strtolower(substr($name, 3));
            return $prefix === 'set'
                ? $this->__set($propertyName, ...$arguments)
                : $this->__get($propertyName);
        }
    }
}