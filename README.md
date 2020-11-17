# 事件管理器

[![GitHub release](https://img.shields.io/github/release/raylin666/event.svg)](https://github.com/raylin666/event/releases)
[![PHP version](https://img.shields.io/badge/php-%3E%207-orange.svg)](https://github.com/php/php-src)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](#LICENSE)

### 环境要求

* PHP >=7.2

### 安装说明

```
composer require "raylin666/event"
```

### 使用方式

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
        public function handle(object $event)
        {
            // TODO: Implement handle() method.
    
            $this->getEvent()->setId(33);
            $event->setId(20);
            dump($event->getId());
        }
    }
    
    class start1Listener extends \Raylin666\Event\Contracts\ListenerAbstract
    {
        public function handle(object $event)
        {
            // TODO: Implement handle() method.
            dump(1);
        }
    }
    
    class start2Listener extends \Raylin666\Event\Contracts\ListenerAbstract
    {
        public function handle(object $event)
        {
            // TODO: Implement handle() method.
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
            'name' => 'engr'
        ],
        2
    )));

## 更新日志

请查看 [CHANGELOG.md](CHANGELOG.md)

### 贡献

非常欢迎感兴趣，愿意参与其中，共同打造更好PHP生态，Swoole生态的开发者。

* 在你的系统中使用，将遇到的问题 [反馈](https://github.com/raylin666/event/issues)

### 联系

如果你在使用中遇到问题，请联系: [1099013371@qq.com](mailto:1099013371@qq.com). 博客: [kaka 梦很美](http://www.ls331.com)

## License MIT
