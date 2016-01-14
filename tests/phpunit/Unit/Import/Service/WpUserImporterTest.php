<?php # -*- coding: utf-8 -*-

namespace W2M\Test\Unit\Import\Service;

use Brain;
use W2M\Import\Service;
use W2M\Test\Helper;

class WpUserImporterTest extends Helper\MonkeyTestCase {

	private $fs_helper;

	/**
	 * runs before each test
	 */
	public function setUp() {

		if ( ! $this->fs_helper ) {
			$this->fs_helper = new Helper\FileSystem;
		}

		parent::setUp();

	}

	/**
	 * @group import_user
	 */
	public function test_import_user() {

		/**
		 * Create mocks for the dependency of the testee (WpUserImporter)
		 */
		#$translation_connector_mock = $this->getMockBuilder( 'W2M\Import\Module\TranslationConnectorInterface' )
		#                                   ->getMock();

		$id_mapper_mock = $this->mock_builder->data_multi_type_id_mapper();

		$user_mock = $this->getMockBuilder( 'W2M\Import\Type\ImportUserInterface' )
		                  ->getMock();

		$testee = new Service\WpUserImporter( $id_mapper_mock );

		/**
		 * Now define the behaviour of the mock object. Each of the specified
		 * methods ( @see ImportUserInterface ) should return a proper value!
		 */
		$user_test_data = array(
			'login'             => 'mocky',
			'email'             => 'mocky@wordpress.com',
		    'first_name'        => 'Mocky',
		    'last_name'         => 'Walboa',
		    'display_name'      => 'Mocky the tester',
			'origin_user_id'    => 33
		);

		$user = array(
			'user_login'    => $user_test_data[ 'login' ],
			'user_email'    => $user_test_data[ 'email' ],
			'first_name'    => $user_test_data[ 'first_name' ],
			'last_name'     => $user_test_data[ 'last_name' ],
			'display_name'  => $user_test_data[ 'display_name' ]
		);

		$origin_user_id = 3;
		$local_user_id = 15;

		foreach ( $user_test_data as $method => $return_value ) {

			$user_mock->expects( $this->atLeast( 1 ) )
			          ->method( $method )
			          ->willReturn( $return_value );

		}

		Brain\Monkey\Functions::expect( 'wp_insert_user' )
		                      ->atLeast()
		                      ->once()
		                      ->with( $user )
		                      ->andReturn( $local_user_id );

		Brain\Monkey\Functions::when( 'is_wp_error' )
		                      ->justReturn( FALSE );

		#$this->markTestSkipped( 'Under construction…' );

		$testee->import_user( $user_mock );


	}

}
