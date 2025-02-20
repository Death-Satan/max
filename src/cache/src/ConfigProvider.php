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

namespace Max\Cache;

class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'bindings' => [
                'Psr\SimpleCache\CacheInterface'     => 'Max\Cache\Cache',
                'Max\Cache\Contracts\CacheInterface' => 'Max\Cache\Cache',
            ],
            'publish'  => [
                [
                    'name'        => 'cache',
                    'source'      => __DIR__ . '/../publish/cache.php',
                    'destination' => dirname(__DIR__, 4) . '/config/cache.php',
                ]
            ],
        ];
    }
}
