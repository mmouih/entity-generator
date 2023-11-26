<?php

declare(strict_types=1);

namespace EntityGenerator\Component;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\String\Inflector\EnglishInflector;

/**
 * String transformation and processing
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class StringProcessor
{
    public function __construct(
        private readonly CamelCaseToSnakeCaseNameConverter $camelCaseToSnakeCaseNameConverter,
        private readonly EnglishInflector $inflector
    ) {
    }

    public function toCamelCase(string $str): string
    {
        if (preg_match('/^[A-Z\-_\d]+$/', $str)) {
            $str = strtolower($str);
        }

        return $this->camelCaseToSnakeCaseNameConverter->denormalize(
            str_replace('-', '_', $str)
        );
    }

    /**
     * Singularize an english word
     * Note: side effect: if a word is already singular inexpected behaviour could occur!
     * Ex: Address -> Addres!
     */
    public function singularize(string $word): string
    {
        // if singular found we take the first proposition of the infector otherwise we return the orginal word
        if (($singular = $this->inflector->singularize($word)) === []) {
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
