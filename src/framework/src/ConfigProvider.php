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

namespace Max\Framework;

class ConfigProvider
{
    /**
     * @return string[][]
     */
    public function __invoke(): array
    {
        return [
            'commands' => [
                'Max\Framework\Console\Commands\RouteListCommand',
                'Max\Framework\Console\Commands\ControllerMakeCommand',
                'Max\Framework\Console\Commands\MiddlewareMakeCommand',
            ]
        ];
    }
}
