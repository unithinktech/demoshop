<?php

namespace SS6\ShopBundle\Component\Javascript\Compiler;

use PLUG\JavaScript\JParser;
use PLUG\JavaScript\JTokenizer;

class JsCompiler {

	/**
	 * @var \SS6\ShopBundle\Component\Javascript\Compiler\JsCompilerPassInterface[]
	 */
	private $compilerPasses;

	/**
	 * @param \SS6\ShopBundle\Component\Javascript\Compiler\JsCompilerPassInterface[] $compilerPasses
	 */
	public function __construct(array $compilerPasses) {
		$this->compilerPasses = $compilerPasses;
	}

	/**
	 * @param string $content
	 * @return string
	 */
	public function compile($content) {
		$node = JParser::parse_string($content, true, JParser::class, JTokenizer::class);
		/* @var $node \PLUG\JavaScript\JNodes\nonterminal\JProgramNode */

		foreach ($this->compilerPasses as $compilerPass) {
			$compilerPass->process($node);
		}

		return $node->format();
	}

}
