<?php # -*- coding: utf-8 -*-

namespace W2M\Import\Service;

use W2M\Import\Data;
use W2M\Import\Type;

class WpObjectImporter implements ObjectImporterInterface {

	/**
	 * @var TranslationConnectorInterface
	 */
	private $translation_connector;

	/**
	 * @var Data\IdMapperInterface
	 */
	private $id_mapper;

	/**
	 * Todo: specify this
	 */
	private $ancestor_resolver;

	/**
	 * @param TranslationConnectorInterface $translation_connector
	 * @param Data\IdMapperInterface $id_mapper
	 * @param $ancestor_resolver (Not specified yet)
	 */
	public function __construct(
		TranslationConnectorInterface $translation_connector,
		Data\IdMapperInterface $id_mapper,
		$ancestor_resolver = NULL
	) {

		$this->translation_connector = $translation_connector;
		$this->id_mapper             = $id_mapper;
		$this->ancestor_resolver     = $ancestor_resolver;
	}

	/**
	 * @param Type\ImportTermInterface $term
	 * @return bool|\WP_Error
	 */
	public function import_term( Type\ImportTermInterface $term ) {

		// TODO: Implement import_term() method.

		// 1.[✓] Insert Term via wp_insert_term()
		// 2.[✓] set the new term_id(!) via $term->id( $new_term_id );
		// 3.[✓] map origin_parent_term_id() via $this->id_mapper->local_id( 'term', $origin_parent_id )
		// 4.[ ] connect translations $this->translation_connector->link_term( $new_term, $term );

		$term_args = array(
			'description' => $term->description(),
			'parent'      => $this->id_mapper->local_id( 'term', $term->origin_parent_term_id() ),
			'slug'        => $term->slug()
		);

		$result = wp_insert_term(
			$term->name(),
			$term->taxonomy(),
			$term_args
		);

		if ( is_wp_error( $result ) ) {
			/**
			 * Attach error handler/logger here
			 *
			 * @param WP_Error
			 * @param Type\ImportTermInterface
			 */
			do_action( 'w2m_import_term_error', $result, $term );
		}

		$term->id( $result[ 'term_id' ] );
		$wp_term = get_term_by( 'id', $result[ 'term_id' ], $term->taxonomy() );

		//Todo: resolve locale relations
		$term->locale_relations();


		/**
		 * Todo: resolve ancestor relation
		 * Here we don't know and should not depend on whether the parent was already
		 * imported or not.
		 *
		 * $ansestor_resolver->resolve_term( $new_term, $term );
		 */

		/**
		 * @param stdClass|WP_Term
		 * @param Type\ImportTermInterface
		 */
		do_action( 'w2m_term_imported', $wp_term, $term );
	}

	/**
	 * @param Type\ImportPostInterface $post
	 * @return bool|\WP_Error
	 */
	public function import_post( Type\ImportPostInterface $post ) {

		// 1. Insert Term via wp_insert_term()
		// 2. set the new term_id(!) via $term->id( $new_term_id );
		// 3. connect translations $this->translation_connector->link_term( $new_post, $post );

		/**
		 * Todo: resolve ancestor relation
		 * Here we don't know and should not depend on whether the parent was already
		 * imported or not.
		 *
		 * $ansestor_resolver->resolve_term( $new_post, $post );
		 */
	}



}