<?php

use Imponeer\Smarty\Extensions\Debug\DebugExtension;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Smarty\Smarty;

class DebugExtensionTest extends TestCase
{
    private readonly DebugExtension $extension;
    private readonly Smarty $smarty;

    protected function setUp(): void
    {
        $this->extension = new DebugExtension();

        $this->smarty = new Smarty();
        $this->smarty->caching = Smarty::CACHING_OFF;
        $this->smarty->addExtension($this->extension);

        parent::setUp();
    }

    public function testGetModifierCallback(): void
    {
        $callback = $this->extension->getModifierCallback('debug_print_var');
        $this->assertIsCallable($callback);

        $this->assertNull($this->extension->getModifierCallback('unknown_modifier'));
    }

    /**
     * Data provider for testModifierInSmartyTemplate
     */
    public function getInvokeData(): array
    {
        $object = new stdClass();
        $object->test = 'a';

        return [
            'string' => [
                'input' => 'test',
                'expected' => '&quot;test&quot;'
            ],
            'int' => [
                'input' => 5,
                'expected' => '5'
            ],
            'float' => [
                'input' => 4.346,
                'expected' => '4.346'
            ],
            'bool' => [
                'input' => true,
                'expected' => '<i>true</i>'
            ],
            'object' => [
                'input' => $object,
                'expected' => '<b>stdClass Object (1)</b><br><b> -&gt;test</b> = &quot;a&quot;'
            ],
            'array' => [
                'input' => [
                    'key1' => 'value1',
                    'key2' => 42,
                    'nested' => ['a', 'b', 'c']
                ],
                'expected' => '<b>Array (3)</b><br><b>key1</b> =&gt; &quot;value1&quot;<br><b>key2</b> =&gt; 42<br>'
                . '<b>nested</b> =&gt; <b>Array (3)</b><br>&nbsp;&nbsp;<b>0</b> =&gt; &quot;a&quot;<br>&nbsp;&nbsp;'
                . '<b>1</b> =&gt; &quot;b&quot;<br>&nbsp;&nbsp;<b>2</b> =&gt; &quot;c&quot;'
            ]
        ];
    }

    #[DataProvider('getInvokeData')]
    public function testModifierInSmartyTemplate(mixed $input, string $expected): void
    {
        $this->smarty->assign('var', $input);
        $templateCode = urlencode('{$var|debug_print_var}');

        $actualOutput = trim(
            $this->smarty->fetch('eval:urlencode:'.$templateCode)
        );

        $this->assertSame($expected, $actualOutput, 'The debug_print_var modifier did not produce the expected output');
    }
}
