# PSR-14 事件派发与监听器

[![GitHub release](https://img.shields.io/github/release/raylin666/event.svg)](https://github.com/raylin666/event/releases)
[![PHP version](https://img.shields.io/badge/php-%3E%207.2-orange.svg)](https://github.com/php/php-src)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](#LICENSE)

### 环境要求

* PHP >=7.2

### 安装说明

```
composer require "raylin666/event"
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

require_once 'vendor/autoload.php';

$container = new \Raylin666\Container\Container();

\Raylin666\Util\ApplicationContext::setContainer($container);

// 注册事件监听器
$container->bind(\Raylin666\Contract\ListenerProviderInterface::class, \Raylin666\Event\ListenerProvider::class);
// 注册事件发布器
$container->bind(\Raylin666\Contract\EventDispatcherInterface::class, \Raylin666\Event\Dispatcher::class);
// 注册事件工厂
$container->singleton(\Raylin666\Event\EventFactoryInterface::class, \Raylin666\Event\EventFactory::class);

class onStartEvent extends \Raylin666\Event\Event
{
    public function getEventAccessor(): string
    {
        // TODO: Implement getEventAccessor() method.

        return 'onStart';
    }

    public function isPropagationStopped(): bool
    {
        return false;   // 为 true 时, 不执行该事件绑定的所有监听
    }
}

class onStartListener
{
    public function init()
    {
        var_dump('onStart 监听开始');
    }
}

class onStartTwoListener
{
    public static function end($event, $name, callable $callback)
    {
        var_dump($event, $name, call($callback));
    }
}

// 事件注册
$container->get(\Raylin666\Event\EventFactoryInterface::class)->listener()->addListener('onStart', ['onStartListener', 'init']);
$container->get(\Raylin666\Event\EventFactoryInterface::class)->listener()->addListener('onStart', ['onStartTwoListener', 'end', ['onStart', function () {
    return strval(123456);
}]]);
// 事件发布
$container->get(\Raylin666\Event\EventFactoryInterface::class)->dispatcher()->dispatch(new onStartEvent());

//  输出
/*
string(20) "onStart 监听开始"
object(onStartEvent)#12 (0) {
}
string(7) "onStart"
string(6) "123456"
*/


### 订阅器 [订阅器(Subscriber)实际上是对 ListenerProvider::addListener 的一种装饰]
    /* 
        利用 ListenerProvider::addListener 添加事件和监听器的关系，这种方式比较过程化，
        也无法体现出一组事件之间的关系，所以在实践中往往会提出“订阅器”的概念
    */

class onStartSubscriber implements \Raylin666\Contract\SubscriberInterface
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
        return (new onStartListener())->init();
    }

    public function onStartTwoListener($event)
    {
        return onStartTwoListener::end($event, 'enen', function () {
            return 'haha';
        });
    }
}

/*
 * 相当于上述的:
 * $container->get(\Raylin666\Event\EventFactoryInterface::class)->listener()->addListener('onStart', ['onStartListener', 'init']);
   $container->get(\Raylin666\Event\EventFactoryInterface::class)->listener()->addListener('onStart', ['onStartTwoListener', 'end', ['onStart', function () {
       return strval(123456);
   }]]);
   包装体
 * */
$container->get(\Raylin666\Event\EventFactoryInterface::class)->listener()->addSubscriber(new onStartSubscriber());
$container->get(\Raylin666\Event\EventFactoryInterface::class)->dispatcher()->dispatch(new onStartEvent());
/**
* 也支持：
* $container->get(\Raylin666\Event\EventFactoryInterface::class)->addSubscriber(new onStartSubscriber());
  $container->get(\Raylin666\Event\EventFactoryInterface::class)->dispatch(new onStartEvent());
 * 
 * 因为 EventFactoryInterface 实现了 __call 方法
 */

//  输出
/*
string(20) "onStart 监听开始"
object(onStartEvent)#11 (0) {
}
string(4) "enen"
string(4) "haha"
*/

```

### 更新日志

请查看 [CHANGELOG.md](CHANGELOG.md)

### 贡献

非常欢迎感兴趣，愿意参与其中，共同打造更好PHP生态，Swoole生态的开发者。

* 在你的系统中使用，将遇到的问题 [反馈](https://github.com/raylin666/event-dispatcher/issues)

### 联系

如果你在使用中遇到问题，请联系: [1099013371@qq.com](mailto:1099013371@qq.com). 博客: [kaka 梦很美](http://www.ls331.com)

## License MIT
