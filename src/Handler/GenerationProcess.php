<?php

declare(strict_types=1);

namespace EntityGenerator\Handler;

use stdClass;
use Nette\PhpGenerator\PhpFile;
use EntityGenerator\Type\GenerateCommandArgs;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class GenerationProcess
{
    public function __construct(
        private JsonDecode $decoder,
        private SchemaResolver $schemaResolver,
        private EntityGenerator $entityGenerator,
        private Printer $printer,
    ) {
    }

    /**
     * @return array<string> List of printed files
     */
    public function handle(GenerateCommandArgs $argument): array
    {
        $schema = $this->schemaResolver->resolve(
            $this->decode($argument)
        );

        $phpFiles = $this->entityGenerator->generate($argument->className, $schema);

        $printed = [];
        foreach ($phpFiles as $generatedClassName => $phpFile) {
            $printed[] = $this->printer->print($generatedClassName . '.php', $phpFile);
        }

        return $printed;
    }

    private function decode(GenerateCommandArgs $argument): mixed
    {
        if ($argument->isFile() && !file_exists($argument->payload)) {
            throw new \InvalidArgumentException(sprintf('File %s does not exit!', $argument->payload));
        }

        if ($argument->isFile()) {
            $content = file_get_contents($argument->payload) ?: '';
        } else {
            $content = $argument->payload ?: '{}';
        }

        return (array)$this->decoder->decode($content, $argument->format);
    }
}
