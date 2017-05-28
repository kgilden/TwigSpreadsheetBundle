<?php

namespace MewesK\TwigSpreadsheetBundle\Twig\Node;

use Twig_Compiler;
use Twig_Node;
use Twig_Node_Expression;

/**
 * Class XlsRowNode
 *
 * @package MewesK\TwigSpreadsheetBundle\Twig\Node
 */
class XlsRowNode extends Twig_Node implements SyntaxAwareNodeInterface
{
    /**
     * @param Twig_Node_Expression $index
     * @param Twig_Node $body
     * @param int $line
     * @param string $tag
     */
    public function __construct(Twig_Node_Expression $index, Twig_Node $body, $line = 0, $tag = 'xlsrow')
    {
        parent::__construct(['index' => $index, 'body' => $body], [], $line, $tag);
    }

    /**
     * @param Twig_Compiler $compiler
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this)
            ->write('$context[\'phpSpreadsheetWrapper\']->setRowIndex(')
            ->subcompile($this->getNode('index'))
            ->raw(');' . PHP_EOL)
            ->write('$context[\'phpSpreadsheetWrapper\']->startRow($context[\'phpSpreadsheetWrapper\']->getRowIndex());' . PHP_EOL)
            ->write('$context[\'phpSpreadsheetWrapper\']->setRowIndex(0);' . PHP_EOL)
            ->subcompile($this->getNode('body'))
            ->addDebugInfo($this)
            ->write('$context[\'phpSpreadsheetWrapper\']->endRow();' . PHP_EOL);
    }

    /**
     * @return string[]
     */
    public function getAllowedParents()
    {
        return [
            XlsSheetNode::class
        ];
    }

    /**
     * @return bool
     */
    public function canContainText()
    {
        return false;
    }
}
