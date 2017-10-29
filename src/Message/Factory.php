<?php declare(strict_types=1);

namespace AsyncIrcServer\Message;

use AsyncIrcServer\Message\Exception\Invalid;

class Factory
{
    private const VALIDATION_PATTERN = '~^(:[^ ]+ )?[^ ]+ .*$~';

    private const PARTS_PATTERN = '~^(?:(?P<prefix>:[^ ]+) )?(?P<command>[^ ]+) (?P<parameters>.*)$~';

    public function build(string $message): Message
    {
        if (strlen($message) > 510) {
            throw new Invalid();
        }

        if (!preg_match(self::VALIDATION_PATTERN, $message)) {
            throw new Invalid();
        }

        preg_match(self::PARTS_PATTERN, $message, $messageParts);

        if (!$messageParts['prefix']) {
            return new Message(
                new Command($messageParts['command']),
                $this->buildParameters($messageParts['parameters'])
            );
        }

        return new Message(
            new Command($messageParts['command']),
            $this->buildParameters($messageParts['parameters']),
            new Prefix($messageParts['prefix'])
        );
    }

    private function buildParameters($parameters): Parameters
    {
        $parameterObjects = array_map(function($parameter) {
            return new Parameter($parameter);
        }, explode(' ', $parameters));

        return new Parameters(...$parameterObjects);
    }
}
