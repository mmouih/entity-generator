<?php // phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols, waiting for v8.2 readonly bug fix

declare(strict_types=1);

namespace EntityGenerator\Type;

readonly class ConfigurationType
{
    public function __construct(
        private string $className,
        private string $payload,
        private bool $file = false,
        private string $format = 'json'
    ) {
        if (0 === strlen(trim($payload))) {
            throw new \InvalidArgumentException('The payload is required!');
        }

        if (0 === strlen(trim($className))) {
            throw new \InvalidArgumentException('The className is is required!');
        }

        if (!in_array($format, ['json', 'xml', 'yaml'])) {
            throw new \InvalidArgumentException('The argument format can either be json or xml');
        }

        if ($this->isFile() && !file_exists($this->getPayload())) {
            throw new \InvalidArgumentException(sprintf('File %s does not exit!', $this->getPayload()));
        }
    }

    public function isFile(): bool
    {
        return $this->file;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
