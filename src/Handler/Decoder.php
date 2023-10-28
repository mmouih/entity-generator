<?php

namespace EntityGenerator\Handler;

use EntityGenerator\Type\GenerateCommandArgs;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class Decoder
{
    public function __construct(
        private JsonDecode $decoder,
        private XmlEncoder $xmlEncoder
    ) {
    }

    public function decode(GenerateCommandArgs $argument): mixed
    {
        if ($argument->isFile()) {
            $content = file_get_contents($argument->getPayload()) ?: '';
        } else {
            $content = $argument->getPayload() ?: '{}';
        }

        return match ($argument->getFormat()) {
            'json' => (array)$this->decoder->decode($content, $argument->getFormat()),
            'xml' => (array)$this->xmlEncoder->decode($content, $argument->getFormat()),
            default => throw new \InvalidArgumentException(sprintf('Unsupported format %s', $argument->getFormat())),
        };
    }
}
