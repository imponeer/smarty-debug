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

    /****
     * Initializes the DebugExtension with a debug print variable modifier.
     */
    public function __construct()
    {
        $this->debugPrintVarModifier = new DebugPrintVarModifier();
    }

    /****
     * Returns the callable for the specified modifier if available.
     *
     * If the modifier name is 'debug_print_var', returns the associated modifier callback; otherwise, returns null.
     *
     * @param string $modifierName The name of the requested modifier.
     * @return callable|null The modifier callback if found, or null if not available.
     */
    public function getModifierCallback(string $modifierName)
    {
        if ($modifierName === 'debug_print_var') {
            return $this->debugPrintVarModifier;
        }

        return null;
    }
}
