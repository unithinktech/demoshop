<?php

namespace SS6\ShopBundle\Model\Localization\Grid\Exception;

use Exception;
use SS6\ShopBundle\Model\Localization\Translation\Grid\Exception\TranslationGridException;

class NotImplementedException extends Exception implements TranslationGridException {

	/**
	 * @param string $message
	 * @param \Exception $previous
	 */
	public function __construct($message, Exception $previous = null) {
		parent::__construct($message, 0, $previous);
	}

}