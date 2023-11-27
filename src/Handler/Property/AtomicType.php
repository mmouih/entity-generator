<?php

declare(strict_types=1);

namespace EntityGenerator\Handler\Property;

use EntityGenerator\Type\PropertyMetaData;
use EntityGenerator\Bridge\Symfony\ParameterBagInterface;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class AtomicType implements PropertyHandlerInterface
{
    public function __construct(private readonly ParameterBagInterface $parameterBag)
    {
    }

    public function handle(PropertyMetaData $propertyMetaData, string $propertyType): void
    {
        $property = $propertyMetaData->property;
        $propertyMetaData->property->setNullable(
            $propertyMetaData->definition->isNullable()
        );

        if (true === $this->parameterBag->get('property.type')) {
            // to avoid double null type, we remove the null type from propertyType, it is being handeled with the setNullable method
            $this->handleTypeDefinition($propertyMetaData, str_replace(['|null', 'null|', '?'], '', $propertyType));
        }

        if (true === $this->parameterBag->get('property.phpdoc')) {
            $property->addComment(sprintf('@var %s', $propertyType));
        }
    }

    private function handleTypeDefinition(PropertyMetaData $propertyMetaData, string $propertyType): void
    {
        // We check if the type is scalar or object and format the type accordinly
        if ($propertyMetaData->definition->hasSchema()) {
            $type = sprintf('%s\%s', $propertyMetaData->namespace->getName(), $propertyType);
        } else {
            $type = $propertyType;
        }

        $propertyMetaData->property->setType('null' === $type ? 'mixed' : $type);
    }
}
