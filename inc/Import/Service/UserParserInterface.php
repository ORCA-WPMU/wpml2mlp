<?php # -*- coding: utf-8 -*-

namespace W2M\Import\Service;

use
	W2M\Import\Type,
	SimpleXMLElement;

interface UserParserInterface {

	/**
	 * @param SimpleXMLElement $element
	 *
	 * @return Type\ImportUserInterface|NULL
	 */
	public function parse_user( SimpleXMLElement $element );
}