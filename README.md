# PSR-14 事件派发与监听器

[![GitHub release](https://img.shields.io/github/release/raylin666/event-dispatcher.svg)](https://github.com/raylin666/event-dispatcher/releases)
[![PHP version](https://img.shields.io/badge/php-%3E%207.2-orange.svg)](https://github.com/php/php-src)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](#LICENSE)

### 环境要求

* PHP >=7.2

### 安装说明

```
composer require "raylin666/event-dispatcher"
```

### 使用方式

#### event 是一个事件派发系统。它派发一个事件，并以优先级顺序调用预先定义的事件处理程序。

事件系统由以下5个概念构成：

    事件 (Event): Event 是事件信息的载体，它往往围绕一个动作进行描述，例如 “用户被创建了”、“准备导出 excel 文件” 等等，Event 的内部需要包含当前事件的所有信息，以便后续的处理程序使用。
    监听器 (Listener): Listener 是事件处理程序，负责在发生某一事件(Event)时执行特定的操作。
    Listener Provider: 它负责将事件(Event)与监听器(Listener)进行关联，在触发一个事件时，Listener Provider 需要提供绑定在该事件上的所有监听器。
    派发器 (Dispatcher): 负责通知某一事件发生了。我们所说的“向某一目标派发一个事件”，这里的“目标”指的是 Listener Provider，也就是说，Dispatcher 向 Listener Provider 派发了 Event。
    订阅器 (Subscriber): 订阅器是 Listener Provider 的扩展，它可以将不同的事件和订阅器里的方法进行自由绑定，这些操作都在订阅器内部进行，这样可以将同类事件的绑定与处理内聚，便于管理。

```php

<?php

require 'vendor/autoload.php';

$eventDispatcher = new \Raylin666\EventDispatcher\Dispatcher;

$listenerProvider = new \Raylin666\EventDispatcher\ListenerProvider();

$eventDispatcher($listenerProvider);

$listenerProvider->addListener('lang', function () {
    echo "golang \n";
});

$listenerProvider->addListener('lang', function () {
    echo "php \n";
}, 2);

$listenerProvider->addListener('lang', function () {
    echo "java \n";
});

class LangEvent extends \Raylin666\EventDispatcher\Event
{
    public function getEventAccessor(): string
    {
        // TODO: Implement getEventAccessor() method.

        return 'lang';
    }

    public function isPropagationStopped(): bool
    {
        // 事件是否需要执行, 为 true 时 不执行该事件绑定的所有监听
        return false;
    }
}

$eventDispatcher->dispatch(new LangEvent());

//  输出
/*
    php 
    java 
    golang 
*/


### 订阅器 [订阅器(Subscriber)实际上是对 ListenerProvider::addListener 的一种装饰]
    /* 
        利用 ListenerProvider::addListener 添加事件和监听器的关系，这种方式比较过程化，
        也无法体现出一组事件之间的关系，所以在实践中往往会提出“订阅器”的概念
    */

class OnStartEvent extends \Raylin666\EventDispatcher\Event
{
    public function getEventAccessor(): string
    {
        // TODO: Implement getEventAccessor() method.

        return 'onStart';
    }

    public function isPropagationStopped(): bool
    {
        // 事件是否需要执行, 为 true 时 不执行该事件绑定的所有监听
        return false;
    }
}

class OnStartSubscriber implements \Raylin666\Contract\SubscriberInterface
{
    public function subscribe(Closure $subscriber)
    {
        // TODO: Implement subscribe() method.

        $subscriber(
            'onStart',
            'onStartListener',
            'onStartTwoListener'
        );
    }

    public function onStartListener()
    {
        echo "我是开始监听事件 1 \n";
    }

    public function onStartTwoListener(OnStartEvent $event)
    {
        return call_user_func_array(function (OnStartEvent $event, $writeString) {
            var_dump($event->getEventAccessor());
            var_dump($writeString);
        }, [$event, "我是开始监听事件 2"]);
    }
}

$listenerProvider->addSubscriber(new OnStartSubscriber());

$eventDispatcher->dispatch(new OnStartEvent());

//  输出
/*
    我是开始监听事件 1 
    string(7) "onStart"
    string(26) "我是开始监听事件 2"
*/

```

## 更新日志

请查看 [CHANGELOG.md](CHANGELOG.md)

### 联系

如果你在使用中遇到问题，请联系: [1099013371@qq.com](mailto:1099013371@qq.com). 博客: [kaka 梦很美](http://www.ls331.com)

## License MIT
