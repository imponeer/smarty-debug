<?php

namespace Imponeer\Smarty\Extensions\Debug;

use ErrorException;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\AbstractDumper;

class DebugPrintVarModifier
{
    private readonly VarCloner $cloner;
    private readonly AbstractDumper $dumper;

    public function __construct()
    {
        $this->cloner = new VarCloner();
        $this->dumper = (PHP_SAPI === 'cli') ? new CliDumper() : new HtmlDumper();
    }

    /**
     * Executes plugin function
     *
     * @throws ErrorException
     */
    public function __invoke(mixed $var): string
    {
        $memoryStream = fopen('php://memory', 'r+b');

        $this->dumper->dump(
            $this->cloner->cloneVar($var),
            $memoryStream
        );

        $contents = stream_get_contents($memoryStream, -1, 0);

        fclose($memoryStream);

        return $contents;
    }
}