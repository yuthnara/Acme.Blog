<?php

/*                                                                        *
 * This script belongs to the TYPO3 Flow framework.                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Tests\FunctionalTestCase;
use TYPO3\Flow\Persistence\Doctrine\PersistenceManager;
use WE\Testing\Behat\Context\ApplicationContext;

class BaseFunctionalTestCase extends FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = TRUE;

	/**
	 * @var boolean
	 */
	protected $testableSecurityEnabled = TRUE;

	/**
	 * @var ApplicationContext
	 */
	protected $applicationContext;

	/**
	 * @var string
	 */
	protected $fixturePath = 'Application/Acme.Blog/Tests/Behaviour/Fixtures';


	/**
	 * Sets up any fixtures and parameters. This method is run before every test.
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		if (! $this->persistenceManager instanceof PersistenceManager) {
			$this->markTestSkipped('Doctrine persistence is not enabled');
		}

		$this->applicationContext = new ApplicationContext($this->fixturePath, $this->objectManager);
	}

}
