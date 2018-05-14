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

	public function find($key) {
		if(preg_match("/^[0-9A-F]{8}\-(?:[0-9A-F]{4}\-){3}[0-9A-f]{12}$/i", $key)) {
			return $this->repository->find($key);
		} else {
			return $this->repository->findBy(array('username'=>$key))[0];
		}
	}

	public function post($array) {
		$newuser = User::fromArray($array);
		$this->entityManager->persist($newuser);
		$this->entityManager->flush();
	}
}
?>
