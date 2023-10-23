<?php

declare(strict_types=1);

namespace EntityGenerator\Handler\Property;

use EntityGenerator\Type\PropertyMetaData;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
interface PropertyHandlerInterface
{
    public function handle(PropertyMetaData $propertyMetaData, string $propertyType): void;
}
