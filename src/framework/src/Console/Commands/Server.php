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

namespace Max\Framework\Console\Commands;

use Max\Config\Repository;
use Max\Console\Commands\Command;
use Max\Di\Context;
use Max\Event\EventDispatcher;
use Psr\Container\ContainerExceptionInterface;
use ReflectionException;
use RuntimeException;

class Server extends Command
{
    /**
     * @var string
     */
    protected string $name = 'server';

    /**
     * @var string
     */
    protected string $description = 'Manage your swoole server.';

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    public function run()
    {
        echo 'PHP:' . PHP_VERSION . PHP_EOL;
        echo 'swoole:' . SWOOLE_VERSION . PHP_EOL;
        $container       = Context::getContainer();
        $eventDispatcher = $container->make(EventDispatcher::class);
        $repository      = $container->make(Repository::class);
        switch ($this->input->getFirstArgument()) {
            case 'start':
                $server = new \Max\Server\Server($repository->get('server'), $eventDispatcher);
                $container->set(\Max\Server\Server::class, $server);
                $server->start();
                break;
            case 'stop':
                $pids = [
                    '/var/run/max-php-manager.pid',
                    '/var/run/max-php-master.pid',
                ];
                foreach ($pids as $pid) {
                    if (!file_exists($pid)) {
                        throw new RuntimeException('服务没有运行');
                    }
                    posix_kill((int)file_get_contents($pid), SIGTERM);
                    unlink($pid);
                }
                echo 'Server stopped!' . PHP_EOL;
                break;
            default:
                echo 'Please input action \'start\' or \'stop\'' . PHP_EOL;
        }
    }
}
