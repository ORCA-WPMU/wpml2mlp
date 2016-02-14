<?php # -*- coding: utf-8 -*-

namespace W2M\Import\Filter;

use
	W2M\Import\Type;

/**
 * Interface ImportMetaFilterInterface
 *
 * Filters the value of ImportMetaInterface instance
 *
 * @package W2M\Import\Filter
 */
interface ImportMetaFilterInterface {

	/**
	 * @param Type\ImportMetaInterface $meta
	 * @param int $object_id
	 *
	 * @return mixed (The filtered value)
	 */
	public function filter_value( Type\ImportMetaInterface $meta, $object_id );
}