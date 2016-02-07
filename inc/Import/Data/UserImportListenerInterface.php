<?php # -*- coding: utf-8 -*-

namespace W2M\Import\Data;

use
	W2M\Import\Type,
	WP_User;

interface UserImportListenerInterface {

	/**
	 * @wp-hook w2m_user_imported
	 *
	 * @param WP_User $wp_user
	 * @param Type\ImportUserInterface $import_user
	 */
	public function record_user( WP_User $wp_user, Type\ImportUserInterface $import_user );
}