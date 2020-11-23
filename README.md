# PSR-14 事件派发与监听器

[![GitHub release](https://img.shields.io/github/release/raylin666/event-dispatcher.svg)](https://github.com/raylin666/event-dispatcher/releases)
[![PHP version](https://img.shields.io/badge/php-%3E%207-orange.svg)](https://github.com/php/php-src)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](#LICENSE)

### 环境要求

* PHP >=7.2

### 安装说明

```
composer require "raylin666/event-dispatcher"
```

### 使用方式

#### event-dispatcher 是一个事件派发系统。它派发一个事件，并以优先级顺序调用预先定义的事件处理程序。

事件系统由以下5个概念构成：

    事件 (Event): Event 是事件信息的载体，它往往围绕一个动作进行描述，例如 “用户被创建了”、“准备导出 excel 文件” 等等，Event 的内部需要包含当前事件的所有信息，以便后续的处理程序使用。
    监听器 (Listener): Listener 是事件处理程序，负责在发生某一事件(Event)时执行特定的操作。
    Listener Provider: 它负责将事件(Event)与监听器(Listener)进行关联，在触发一个事件时，Listener Provider 需要提供绑定在该事件上的所有监听器。
    派发器 (EventDispatcher): 负责通知某一事件发生了。我们所说的“向某一目标派发一个事件”，这里的“目标”指的是 Listener Provider，也就是说，EventDispatcher 向 Listener Provider 派发了 Event。
    订阅器 (Subscriber): 订阅器是 Listener Provider 的扩展，它可以将不同的事件和订阅器里的方法进行自由绑定，这些操作都在订阅器内部进行，这样可以将同类事件的绑定与处理内聚，便于管理。

```php

<?php

require_once 'vendor/autoload.php';

class onStart1
{
    public function event1()
    {
        echo 'onStart1-event1' . PHP_EOL;
    }

    public function event2($event, $name, $callback)
    {
        echo $name . $callback();
    }
}

class onStart2
{
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        echo $this->name . PHP_EOL;
    }
}

class Listener implements \Raylin666\EventDispatcher\Contracts\ListenerInterface
{
    public function process(object $event)
    {
        // TODO: Implement process() method.

        echo 'Listener-process' . PHP_EOL;
    }
}

$container = new Raylin666\Container\Container();
$listenerProvider = new \Raylin666\EventDispatcher\ListenerProvider();
$container->add(\Raylin666\EventDispatcher\Contracts\ListenerProviderInterface::class, $listenerProvider);
$eventDispatcherFactory = new \Raylin666\EventDispatcher\EventDispatcherFactory;
$listenerProvider = $container->get(\Raylin666\EventDispatcher\Contracts\ListenerProviderInterface::class);
$eventDispatcher = $eventDispatcherFactory($container);

$onStart1 = new onStart1();
$onStart2 = new onStart2('hello world');

$listenerProvider->addListener('onStart', [$onStart1, 'event1'], 2);
$listenerProvider->addListener('onStart', [$onStart1, 'event2', ['hei raylin', function () {
    echo 'event2 callback' . PHP_EOL;
}]], 3);
$listenerProvider->addListener('onStart', [$onStart2, 'getName'], 1);
$listenerProvider->addListener('onStart', function ($event) {
    echo $event->getName() . PHP_EOL;
});
$listenerProvider->addListener('onStart', Listener::class);

class onStartEvent extends \Raylin666\EventDispatcher\Event
{
    public function getName(): string
    {
        // TODO: Implement getName() method.

        return 'onStart';
    }

    public function isPropagationStopped(): bool
    {
        // TODO: Implement isPropagationStopped() method.

        return false;
    }
}

$onStartEvent = new onStartEvent();

$eventDispatcher->dispatch($onStartEvent);

//  输出
/*
event2 callback
hei raylinonStart1-event1
onStart
hello world
Listener-process
*/


### 订阅器 [订阅器(Subscriber)实际上是对 ListenerProvider::addListener 的一种装饰]
    /* 利用 ListenerProvider::addListener 添加事件和监听器的关系，这种方式比较过程化，
        也无法体现出一组事件之间的关系，所以在实践中往往会提出“订阅器”的概念*/

class onStartSubscriber implements \Raylin666\EventDispatcher\Contracts\SubscriberInterface
{
    public function subscribe(Closure $subscriber)
    {
        // TODO: Implement subscribe() method.

        $subscriber(
            'swoole.onstart',
            'swooleEvent1',
            ['swooleEvent2', 2]
        );
    }

    public function swooleEvent1(\Raylin666\EventDispatcher\Contracts\EventInterface $event)
    {
        echo 'swooleEvent1' . PHP_EOL;
    }

    public function swooleEvent2(\Raylin666\EventDispatcher\Contracts\EventInterface $event)
    {
        echo 'swooleEvent2' . PHP_EOL;
    }
}

$listenerProvider->addSubscriber(new onStartSubscriber());

class swooleOnStartEvent extends \Raylin666\EventDispatcher\Event
{
    public function getName(): string
    {
        // TODO: Implement getName() method.

        return 'swoole.onstart';
    }
}

$swooleOnStartEvent = new swooleOnStartEvent();

$eventDispatcher->dispatch($swooleOnStartEvent);

//  输出
/*
event2 callback
hei raylinonStart1-event1
onStart
hello world
Listener-process
swooleEvent2
swooleEvent1
*/

?>

```

## 更新日志

请查看 [CHANGELOG.md](CHANGELOG.md)

### 贡献

非常欢迎感兴趣，愿意参与其中，共同打造更好PHP生态，Swoole生态的开发者。

* 在你的系统中使用，将遇到的问题 [反馈](https://github.com/raylin666/event-dispatcher/issues)

### 联系

如果你在使用中遇到问题，请联系: [1099013371@qq.com](mailto:1099013371@qq.com). 博客: [kaka 梦很美](http://www.ls331.com)

## License MIT
