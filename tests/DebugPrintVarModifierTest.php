<?php

use Imponeer\Smarty\Extensions\Debug\DebugPrintVarModifier;
use PHPUnit\Framework\TestCase;

class DebugPrintVarModifierTest extends TestCase
{

    /**
     * @var DebugPrintVarModifier
     */
    private $plugin;
    /**
     * @var Smarty
     */
    private $smarty;

    protected function setUp(): void
    {
        $this->plugin = new DebugPrintVarModifier();

        $this->smarty = new Smarty();
        $this->smarty->caching = Smarty::CACHING_OFF;
        $this->smarty->registerPlugin(
            'modifier',
            $this->plugin->getName(),
            [$this->plugin, 'execute']
        );

        parent::setUp();
    }

    public function testGetName(): void
    {
        $this->assertSame('debug_print_var', $this->plugin->getName());
    }

    public function getInvokeData(): array {
        $object = new stdClass();
        $object->test = 'a';

        return [
            'string' => [
                'test',
                '"test"'
            ],
            "int" => [
                5,
                '5'
            ],
            "float" => [
                4.346,
                "4.346"
            ],
            "bool" => [
                true,
                "true"
            ],
            "object" => [
                $object,
                urldecode('%7B%23304%0A++%2B%22test%22%3A+%22a%22%0A%7D')
            ],
            "array" => [
                [
                    1
                ],
                urldecode('array%3A1+%5B%0A++0+%3D%3E+1%0A%5D')
            ]
        ];
    }

    /**
     * @dataProvider getInvokeData
     */
    public function testInvoke($originalData, string $shouldBeRendered): void
    {
        $this->smarty->assign('var', $originalData);
        $src = urlencode('{$var|debug_print_var}');
        $ret = trim(
            $this->smarty->fetch('eval:urlencode:'.$src)
        );

        $this->assertSame($shouldBeRendered, $ret);
    }

}