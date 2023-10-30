<?php

declare(strict_types=1);

namespace EntityGenerator\Handler\Property;

use Nette\PhpGenerator\Type;
use EntityGenerator\Type\PropertyMetaData;
use EntityGenerator\Bridge\Symfony\ParameterBag;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class CollectionType implements PropertyHandlerInterface
{
    public function __construct(private ParameterBag $parameterBag)
    {
    }

    public function handle(PropertyMetaData $propertyMetaData, string $propertyType): void
    {
        $property = $propertyMetaData->property;
        $property->setValue([]);
        if (true === $this->parameterBag->get('property.type')) {
            $property->setType(TYPE::Iterable);
        }

        if (true === $this->parameterBag->get('property.phpdoc')) {
            // Add collection type documentation @var iterable<Type>
            $property->addComment(sprintf('@var %s<%s>', TYPE::Iterable, $propertyType));
        }
    }
}
