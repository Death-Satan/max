<?php
declare(strict_types=1);

return [
    'default'     => 'redis',     // 默认连接
    'sleep'       => 0.4,           // 异常时候等待时长/秒
    'connections' => [
        'redis' => [
            'driver' => 'Max\Queue\Queues\Redis',
            'config' => [
                'host'     => '127.0.0.1',
                'port'     => 6379,
                'pass'     => '',
                'database' => 1,
            ],
        ]
    ],
];
