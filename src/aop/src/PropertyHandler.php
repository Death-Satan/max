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

namespace Max\Aop;

use Max\Aop\Collectors\PropertyAttributeCollector;

trait PropertyHandler
{
    protected bool $__propertyHandled = false;

    protected function __handleProperties(): void
    {
        if (!$this->__propertyHandled) {
            foreach (PropertyAttributeCollector::getClassPropertyAttributes(self::class) as $property => $attributes) {
                foreach ($attributes as $attribute) {
                    $attribute->handle($this, $property);
                }
            }
            $this->__propertyHandled = true;
        }
    }
}
