<?php

namespace Imponeer\Smarty\Extensions\Debug;

use Smarty\Extension\Base;

/**
 * Debug extension for Smarty
 *
 * Provides debug_print_var modifier
 */
class DebugExtension extends Base
{
    private readonly DebugPrintVarModifier $debugPrintVarModifier;

    public function __construct()
    {
        $this->debugPrintVarModifier = new DebugPrintVarModifier();
    }

    public function getModifierCallback(string $modifierName): ?callable
    {
        return match($modifierName) {
            'debug_print_var' => $this->debugPrintVarModifier,
            default => null
        };
    }
}
