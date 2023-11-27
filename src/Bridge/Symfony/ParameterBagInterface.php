<?php

declare(strict_types=1);

namespace EntityGenerator\Bridge\Symfony;

use UnitEnum;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
interface ParameterBagInterface
{
    public const ROOT_PARAMETER = "entity.generator";
    public function get(string $key, string $root = self::ROOT_PARAMETER): mixed;

    /**
     * @return array<mixed>|bool|float|int|string|UnitEnum
     */
    public function all(string $root = self::ROOT_PARAMETER): mixed;

    public function has(string $key, string $root = self::ROOT_PARAMETER): bool;

    /**
     * @param array<mixed> $config
     */
    public function add(array $config): void;
}
