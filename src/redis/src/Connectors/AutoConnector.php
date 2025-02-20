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

namespace Max\Redis\Connectors;

use ArrayObject;
use Max\Redis\Contracts\ConnectorInterface;
use Max\Redis\RedisConfig;
use Swoole\Coroutine;

class AutoConnector implements ConnectorInterface
{
    protected array        $connectors = ['pool' => PoolConnector::class, 'base' => BaseConnector::class,];
    protected ?ArrayObject $pool       = null;

    public function __construct(protected RedisConfig $config)
    {
        $this->pool = new ArrayObject();
    }

    public function get(): \Redis
    {
        $type = $this->getConnectorType();
        if (!$this->pool->offsetExists($type)) {
            $connector = $this->connectors[$type];
            $this->pool->offsetSet($type, new $connector($this->config));
        }

        return $this->pool->offsetGet($type)->get();
    }

    public function release($redis)
    {
        $this->pool->offsetGet($this->getConnectorType())->release($redis);
    }

    protected function getConnectorType(): string
    {
        return class_exists(Coroutine::class) && Coroutine::getCid() > 0 ? 'pool' : 'base';
    }
}
