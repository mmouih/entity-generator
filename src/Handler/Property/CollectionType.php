<?php

declare(strict_types=1);

namespace EntityGenerator\Handler\Property;

use Nette\PhpGenerator\Type;
use EntityGenerator\Type\PropertyMetaData;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class CollectionType implements PropertyHandlerInterface
{
    /**
     * @param array<string|bool> $parameters
     */
    public function __construct(private array $parameters)
    {
    }

    public function handle(PropertyMetaData $propertyMetaData, string $propertyType): void
    {
        $property = $propertyMetaData->property;
        $property->setValue([]);
        if (true === $this->parameters['property.type']) {
            $property->setType(TYPE::Iterable);
        }

        if (true === $this->parameters['property.phpdoc']) {
            // Add collection type documentation @var iterable<Type>
            $property->addComment(sprintf('@var %s<%s>', TYPE::Iterable, $propertyType));
        }
    }
}
