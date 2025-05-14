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

    /****
     * Initializes the variable cloner and selects the appropriate dumper based on the PHP SAPI.
     */
    public function __construct()
    {
        $this->cloner = new VarCloner();
        $this->dumper = (PHP_SAPI === 'cli') ? new CliDumper() : new HtmlDumper();
    }

    /**
     * Dumps a variable's contents as a formatted string for debugging.
     *
     * Clones and formats the given variable using Symfony's VarDumper, returning the result as a string suitable for CLI or HTML output depending on the environment.
     *
     * @param mixed $var The variable to be dumped.
     * @return string The formatted dump of the variable.
     * @throws ErrorException If an error occurs during dumping.
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