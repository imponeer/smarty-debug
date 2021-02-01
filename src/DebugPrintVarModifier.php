<?php

namespace Imponeer\Smarty\Extensions\Debug;

use Imponeer\Contracts\Smarty\Extension\SmartyFunctionInterface;
use Imponeer\Contracts\Smarty\Extension\SmartyModifierInterface;
use Smarty_Internal_Template;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

/**
 * This describes Smarty debug_print_var var modifier based on symfony var_dumper
 *
 * @package Imponeer\Smarty\Extensions\Dump
 */
class DebugPrintVarModifier implements SmartyModifierInterface
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
        $this->dumper = new HtmlDumper();
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'debug_print_var';
    }

    /**
     * Executes plugin function
     *
     * @param mixed $var Variable to print
     *
     * @return string
     */
    public function execute($var): string {
        $memoryStream = fopen('php://memoryStream', 'r+b');

        $this->dumper->dump(
            $this->cloner->cloneVar($var),
            $memoryStream
        );

        $contents = stream_get_contents($memoryStream, -1, 0);

        fclose($memoryStream);

        return $contents;
    }
}