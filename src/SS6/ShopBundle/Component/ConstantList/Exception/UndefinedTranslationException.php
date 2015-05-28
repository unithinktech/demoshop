<?php

namespace SS6\ShopBundle\Component\ConstantList\Exception;

use Exception;
use SS6\ShopBundle\Component\ConstantList\Exception\ConstantListException;

class UndefinedTranslationException extends Exception implements ConstantListException {

	/**
	 * @param string $constant
	 * @param \Exception|null $previous
	 */
	public function __construct($constant, Exception $previous = null) {
		parent::__construct('Undefined constant translation "' . $constant . '"', 0, $previous);
	}

}
