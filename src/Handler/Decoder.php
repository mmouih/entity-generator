<?php

namespace EntityGenerator\Handler;

use EntityGenerator\Type\ConfigurationType;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
class Decoder
{
    public function __construct(
        private JsonDecode $decoder,
        private XmlEncoder $xmlEncoder,
        private YamlEncoder $yamlEncoder
    ) {
    }

    public function decode(ConfigurationType $argument): mixed
    {
        if ($argument->isFile()) {
            $content = file_get_contents($argument->getPayload()) ?: '';
        } else {
            $content = $argument->getPayload() ?: '{}';
        }

        return match ($argument->getFormat()) {
            'json' => (array)$this->decoder->decode($content, $argument->getFormat()),
            'xml' => (array)$this->xmlEncoder->decode($content, $argument->getFormat()),
            'yaml' => (array)$this->yamlEncoder->decode($content, $argument->getFormat()),
            default => throw new \InvalidArgumentException(sprintf('Unsupported format %s', $argument->getFormat())),
        };
    }
}
