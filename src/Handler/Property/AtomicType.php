<?php

declare(strict_types=1);

namespace EntityGenerator\Handler\Property;

use EntityGenerator\Type\PropertyMetadata;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class AtomicType implements PropertyHandlerInterface
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
        $propertyMetaData->property->setNullable(
            $propertyMetaData->definition->isNullable()
        );

        if (true === $this->parameters['property.type']) {
            // to avoid double null type, we remove the null type from propertyType, it is being handeled with the setNullable method
            $this->handleTypeDefinition($propertyMetaData, str_replace(['|null', 'null|', '?'], '', $propertyType));
        }

        if (true === $this->parameters['property.phpdoc']) {
            $property->addComment(sprintf('@var %s', $propertyType));
        }
    }

    private function handleTypeDefinition(PropertyMetaData $propertyMetaData, string $propertyType): void
    {
        // We check if the type is scalar or object and format the type accordinly
        if ($propertyMetaData->definition->hasSchema()) {
            // todo: loading the proper type right from the start could be a good idea !
            $type = sprintf('%s\%s', $propertyMetaData->namespace->getName(), $propertyType);
        } else {
            $type = $propertyType;
        }

        $propertyMetaData->property->setType($type);
    }
}
