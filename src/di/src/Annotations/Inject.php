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

namespace Max\Di\Annotations;

use Attribute;
use Max\Aop\Contracts\PropertyAttribute;
use Max\Aop\Exceptions\PropertyHandleException;
use Max\Di\Context;
use Max\Di\Reflection;
use Throwable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Inject implements PropertyAttribute
{
    /**
     * @param string|null $id 注入的类型
     */
    public function __construct(protected ?string $id = null)
    {
    }

    public function handle(object $object, string $property): void
    {
        try {
            $container          = Context::getContainer();
            $reflectionProperty = Reflection::property($object::class, $property);
            if ((!is_null($type = $reflectionProperty->getType()) && $type = $type->getName()) || $type = $this->id) {
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($object, $container->make($type));
            }
        } catch (Throwable $throwable) {
            throw new PropertyHandleException('Property assign failed. ' . $throwable->getMessage());
        }
    }
}
