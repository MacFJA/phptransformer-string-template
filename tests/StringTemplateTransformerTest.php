<?php

namespace PhpTransformers\StringTemplate\Test;

use PhpTransformers\StringTemplate\StringTemplateTransformer;
use StringTemplate\Engine;

class StringTemplateTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $engine = new StringTemplateTransformer();
        $this->assertEquals('string-template', $engine->getName());
    }

    public function testRenderFile()
    {
        $engine = new StringTemplateTransformer();

        $actual = $engine->renderFile('tests/Fixtures/template.tpl', array('name' => 'Linus'));

        $this->assertEquals('Hello, Linus!', $actual);
    }

    public function testRender()
    {
        $engine = new StringTemplateTransformer();

        $actual = $engine->render(
            file_get_contents('tests/Fixtures/template.tpl'),
            array('name' => 'Linus')
        );

        $this->assertEquals('Hello, Linus!', $actual);
    }

    public function testDelimiters()
    {
        $engine = new StringTemplateTransformer(array(
            'left_delimiter' => ':',
            'right_delimiter' => ''
        ));

        $actual = $engine->renderFile(
            'tests/Fixtures/template2.tpl',
            array('name' => 'Linus')
        );

        $this->assertEquals('Hello, Linus!', $actual);
    }

    public function testSprintf()
    {
        $engine = new StringTemplateTransformer(array(
            'engine' => 'sprintf'
        ));

        $actual = $engine->renderFile(
            'tests/Fixtures/template3.tpl',
            array('name' => 'Linus')
        );

        $this->assertEquals('Hello, Linus!', $actual);
    }

    public function testDefinedEngine()
    {
        $stringTemplate = new Engine('[@', ']');
        $engine = new StringTemplateTransformer(array('engine' => $stringTemplate));

        $actual = $engine->render(
            'Hello, [@name]!',
            array('name' => 'Linus')
        );

        $this->assertEquals('Hello, Linus!', $actual);
    }
}
