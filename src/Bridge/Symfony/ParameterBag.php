<?php

declare(strict_types=1);

namespace EntityGenerator\Bridge\Symfony;

use UnitEnum;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class ParameterBag
{
    private const ROOT_PARAMETER = "entity.generator";

    public function __construct(private readonly ParameterBagInterface $parameterBag)
    {
    }

    public function get(string $key, string $root = self::ROOT_PARAMETER): mixed
    {
        return $this->parameterBag->get($root)[$key] ?? null;
    }

    /**
     * @return array<mixed>|bool|float|int|string|UnitEnum
     */
    public function all(string $root = self::ROOT_PARAMETER): mixed
    {
        return $this->parameterBag->get($root) ?? [];
    }

    public function has(string $key, string $root = self::ROOT_PARAMETER): bool
    {
        return isset($this->parameterBag->get($root)[$key]);
    }

    /**
     * @param array<mixed> $config
     */
    public function add(array $config): void
    {
        $this->parameterBag->add($config);
    }
}
