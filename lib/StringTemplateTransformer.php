<?php

namespace PhpTransformers\StringTemplate;

use PhpTransformers\PhpTransformer\TransformerInterface;
use StringTemplate\AbstractEngine;
use StringTemplate\Engine;
use StringTemplate\SprintfEngine;

/**
 * Class StringTemplateTransformer.
 *
 * The PhpTransformer for StringTemplate template engine.
 * {@link https://github.com/nicmart/StringTemplate}
 *
 * @author  MacFJA
 * @package PhpTransformers\StringTemplate
 * @license MIT
 */
class StringTemplateTransformer implements TransformerInterface
{
    /** @var Engine|SprintfEngine */
    protected $engine;

    /**
     * The transformer constructor.
     *
     * Options are:
     *   - "engine" the engine type name ("standard" or "sprintf"/"sprintfengine")
     *      or an instance of \StringTemplate\AbstractEngine
     *   - "left_delimiter" the char to use on the left of a variable
     *   - "right_delimiter" the char to use on the right of a variable
     *
     * If "engine" is an instance of \StringTemplate\AbstractEngine,
     * then "left_delimiter" and "right_delimiter" are ignored
     *
     * @param array $options The StringTemplateTransformer options
     */
    public function __construct(array $options = array())
    {
        $defaultOption = array(
            'engine' => 'standard',
            'left_delimiter' => '{',
            'right_delimiter' => '}'
        );
        $options += $defaultOption;

        if ($options['engine'] instanceof AbstractEngine) {
            $this->engine = $options['engine'];
        } else {
            // Create the template engine.
            $this->engine = $this->getEngine(
                $options['engine'],
                $options['left_delimiter'],
                $options['right_delimiter']
            );
        }
    }

    protected function getEngine($key, $left, $right)
    {
        $sprintf = array(
            'sprintf',
            'sprintfengine',
            strtolower('StringTemplate\SprintfEngine'),
            strtolower('\StringTemplate\SprintfEngine')
        );

        if (in_array(strtolower($key), $sprintf, true)) {
            return new SprintfEngine($left, $right);
        }

        return new Engine($left, $right);
    }

    /**
     * Get the transformer name
     *
     * @return string
     */
    public function getName()
    {
        return 'string-template';
    }

    /**
     * Render a file
     *
     * @param string $file The file to render
     * @param array $locals The variable to use in template
     * @return string
     */
    public function renderFile($file, array $locals = array())
    {
        return $this->engine->render(file_get_contents($file), $locals);
    }

    /**
     * Render a string
     *
     * @param string $template The template content to render
     * @param array $locals The variable to use in template
     * @return string
     */
    public function render($template, array $locals = array())
    {
        return $this->engine->render($template, $locals);
    }
}
