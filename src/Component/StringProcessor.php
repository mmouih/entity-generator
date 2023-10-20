<?php

declare(strict_types=1);

namespace EntityGenerator\Component;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\String\Inflector\EnglishInflector;

/**
 * String transformation and processing operations
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class StringProcessor
{
    public function __construct(
        private CamelCaseToSnakeCaseNameConverter $camelCaseToSnakeCaseNameConverter,
        private EnglishInflector $inflector
    ) {
    }

    public function toCamelCase(string $str): string
    {
        return $this->camelCaseToSnakeCaseNameConverter->denormalize($str);
    }

    /**
     * Singularize an english word
     * Note: side effect: if a word is already singular inexpected behaviour could occur!
     * Ex: Address -> Addres!
     *
     * @param string $word
     * @return string
     */
    public function singularize(string $word): string
    {
        // if singular found we take the first proposition of the infector otherwise we return the orginal word
        if (empty($singular = $this->inflector->singularize($word))) {
            return $word;
        }

        return current($singular);
    }

    public function normalizeClassName(string $className, bool $isPlural = false): string
    {
        $singlarClassName = $isPlural ? $this->singularize($className) : $className;

        return ucfirst(
            $this->toCamelCase($singlarClassName)
        );
    }
}
