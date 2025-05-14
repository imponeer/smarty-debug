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
    /**
     * @var DebugPrintVarModifier
     */
    private $debugPrintVarModifier;

    /**
     * DebugExtension constructor.
     */
    public function __construct()
    {
        $this->debugPrintVarModifier = new DebugPrintVarModifier();
    }

    /**
     * Get modifier callback
     *
     * @param string $modifierName Name of the modifier
     *
     * @return callable|null
     */
    public function getModifierCallback(string $modifierName)
    {
        if ($modifierName === 'debug_print_var') {
            return $this->debugPrintVarModifier;
        }

        return null;
    }
}
