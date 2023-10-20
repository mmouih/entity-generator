<?php

declare(strict_types=1);

namespace EntityGenerator\Handler\Property;

use EntityGenerator\Type\PropertyMetadata;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
interface PropertyHandlerInterface
{
    public function handle(PropertyMetadata $propertyMetaData, string $propertyType);
}
