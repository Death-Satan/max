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

namespace Max\Routing\Annotations;

use Attribute;
use Max\Routing\Contracts\MappingInterface;

#[Attribute(Attribute::TARGET_METHOD)]
class RequestMapping implements MappingInterface
{
    /**
     * 默认方法
     *
     * @var array|string[]
     */
    public array $methods = ['GET', 'POST', 'HEAD'];

    /**
     * @param string         $path        路径
     * @param array|string[] $methods     方法
     * @param array          $middlewares 中间件
     * @param string         $domain      域名
     */
    public function __construct(
        public string $path,
        array         $methods = [],
        public array  $middlewares = [],
        public string $domain = ''
    )
    {
        if (!empty($methods)) {
            $this->methods = $methods;
        }
    }
}
