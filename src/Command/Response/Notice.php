<?php declare(strict_types=1);

namespace AsyncIrcServer\Command\Response;

use AsyncIrcServer\Message\Parameters;
use AsyncIrcServer\Message\Prefix;

class Notice
{
    private $prefix;

    private $parameters;

    public function __construct(Prefix $prefix, Parameters $parameters)
    {
        $this->prefix     = $prefix;
        $this->parameters = $parameters;
    }

    public function __toString(): string
    {
        return sprintf(':%s NOTICE %s', $this->prefix, $this->parameters);
    }
}
