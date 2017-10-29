<?php declare(strict_types=1);

namespace AsyncIrcServer\Command\Response;

use AsyncIrcServer\Message\Parameters;
use AsyncIrcServer\Message\Prefix;

class Nick
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
        return sprintf(':%s 001 %s', $this->prefix, $this->parameters);
    }
}
