<?php

declare(strict_types=1);

namespace EntityGenerator\Bridge\Symfony;

use UnitEnum;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface as SymfonyParamBag;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class ParameterBag implements ParameterBagInterface
{
    public function __construct(private readonly SymfonyParamBag $parameterBag)
    {
    }

    public function get(string $key, string $root = self::ROOT_PARAMETER): mixed
    {
        return $this->parameterBag->get($root)[$key] ?? null;
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function add(array $config): void
    {
        $this->parameterBag->add($config);
    }
}
