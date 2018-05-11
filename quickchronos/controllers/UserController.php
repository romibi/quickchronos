<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;

use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\OptimisticLockException;

class UserController {
	protected $entityManager;
	protected $repository;
	public function __construct($entityManager) {
		$this->entityManager = $entityManager;
		$this->repository = $entityManager->getRepository('ch\romibi\quickchronos\User');
	}
}
?>