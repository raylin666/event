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

event-dispatcher 是一个事件派发系统。它派发一个事件，并以优先级顺序调用预先定义的事件处理程序。

事件系统由以下5个概念构成：

    事件 (Event): Event 是事件信息的载体，它往往围绕一个动作进行描述，例如 “用户被创建了”、“准备导出 excel 文件” 等等，Event 的内部需要包含当前事件的所有信息，以便后续的处理程序使用。
    监听器 (Listener): Listener 是事件处理程序，负责在发生某一事件(Event)时执行特定的操作。
    Listener Provider: 它负责将事件(Event)与监听器(Listener)进行关联，在触发一个事件时，Listener Provider 需要提供绑定在该事件上的所有监听器。
    派发器 (EventDispatcher): 负责通知某一事件发生了。我们所说的“向某一目标派发一个事件”，这里的“目标”指的是 Listener Provider，也就是说，EventDispatcher 向 Listener Provider 派发了 Event。
    订阅器 (Subscriber): 订阅器是 Listener Provider 的扩展，它可以将不同的事件和订阅器里的方法进行自由绑定，这些操作都在订阅器内部进行，这样可以将同类事件的绑定与处理内聚，便于管理。

一 、EventDispatcher 的使用

    class a
    {
        public function __construct(string $string)
        {
            dump($string);
        }
    }
    
    $dispatcher = new \Raylin666\Event\EventDispatcher();
    $dispatcher->dispatch(new a('en'));
    dump($dispatcher->getDispatch(a::class));
    
二 、事件与监听器

    class startEvent extends \Raylin666\Event\Contracts\EventAbstract
    {
        public $data;
    
        public $id;
    
        public function __construct($data, $id)
        {
            $this->data = $data;
            $this->id = $id;
        }
    }
    
    class startListener extends \Raylin666\Event\Contracts\ListenerAbstract
    {
        /**
         * @param startEvent $event
         * @return mixed|void
         */
        public function process(object $event)
        {
            // TODO: Implement process() method.
    
            $this->getEvent()->setId(33);
            $event->setId(20);
            dump($event->getId());
        }
    }
    
    class start1Listener extends \Raylin666\Event\Contracts\ListenerAbstract
    {
        public function process(object $event)
        {
            // TODO: Implement process() method.
            dump(1);
        }
    }
    
    class start2Listener extends \Raylin666\Event\Contracts\ListenerAbstract
    {
        public function process(object $event)
        {
            // TODO: Implement process() method.
            dump(2);
        }
    }
    
    $listeners = [
        startEvent::class => [
            startListener::class,
            start1Listener::class
        ],
    ];
    
    $event = new \Raylin666\Event\Event(new \Raylin666\Event\EventRegister(array_keys($listeners)));
    $eventManage = new \Raylin666\Event\EventManager($event);
    foreach ($listeners as $event => $listener) {
        $eventManage->addListener($event, $listener);
    }
    $eventManage->addListener(startEvent::class, [
        start2Listener::class
    ]);
    $eventManage->addListener(startEvent::class, [
        function ($event) {
            dump($event);
        }
    ]);
    
    dump($eventManage->trigger(new startEvent(
        [
            'id' => 1,
            'name' => 'raylin'
        ],
        2
    )));

## 更新日志

请查看 [CHANGELOG.md](CHANGELOG.md)

### 贡献

非常欢迎感兴趣，愿意参与其中，共同打造更好PHP生态，Swoole生态的开发者。

* 在你的系统中使用，将遇到的问题 [反馈](https://github.com/raylin666/event-dispatcher/issues)

### 联系

如果你在使用中遇到问题，请联系: [1099013371@qq.com](mailto:1099013371@qq.com). 博客: [kaka 梦很美](http://www.ls331.com)

## License MIT
