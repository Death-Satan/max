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

namespace Max\Aop\Contracts;

interface CollectorInterface
{
    public static function collectClass(string $class, object $attribute): void;

    public static function collectMethod(string $class, string $method, object $attribute): void;

    public static function collectProperty(string $class, string $property, object $attribute): void;

    public static function collectorMethodParameter(string $class, string $method, string $parameter, object $attribute);
}
