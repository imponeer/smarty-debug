<?php

namespace Imponeer\Smarty\Extensions\Debug;

use ErrorException;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

/**
 * This describes Smarty debug_print_var var modifier based on symfony var_dumper
 *
 * @package Imponeer\Smarty\Extensions\Dump
 */
class DebugPrintVarModifier
{
    /**
     * @var VarCloner
     */
    private $cloner;

    /**
     * @var HtmlDumper
     */
    private $dumper;

    /**
     * DebugPrintVarModifier constructor.
     */
    public function __construct()
    {
        $this->cloner = new VarCloner();
        $this->dumper = (PHP_SAPI === 'cli') ? new CliDumper() : new HtmlDumper();
    }

    /**
     * Executes plugin function
     *
     * @param mixed $var Variable to print
     *
     * @return string
     *
     * @throws ErrorException
     */
    public function __invoke($var): string {
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