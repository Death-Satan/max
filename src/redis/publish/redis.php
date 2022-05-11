<?php

declare(strict_types=1);

/**
 * This file is part of the Max package.
 *
 * (c) Cheng Yao <987861463@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Max\Redis\Connectors\PoolConnector;

return [
    'default'     => 'redis',
    'connections' => [
        'redis' => [
            'connector' => PoolConnector::class,
            'options'   => [
                'host'          => '127.0.0.1',
                'port'          => 6379,
                'auth'          => '',
                'database'      => 0,
                'timeout'       => 3,
                'readTimeout'   => 3,
                'retryInterval' => 3,
                'reserved'      => null,
                'poolSize'      => 64,
            ],
        ]
    ]
];
