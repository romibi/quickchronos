<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;

use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\OptimisticLockException;

class ProjectController {
	protected $entityManager;
	protected $projectRepository;
	public function __construct($entityManager) {
		$this->entityManager = $entityManager;
		$this->projectRepository = $entityManager->getRepository('ch\romibi\quickchronos\Project');
		$this->activityRepository = $entityManager->getRepository('ch\romibi\quickchronos\Activity');
	}

	public function list() {
		return $this->projectRepository->findBy(array());
	}

	public function get($id) {
		return $this->projectRepository->find($id);
	}

	public function put($id, $array) {
		if($id!=$array['id']) throw new \Exception("Error Processing Request", 1);
		$newProject = Project::fromArray($array);
		if(isset($array['members'])) { 
			foreach ($array['members'] as $member) {
				$user = QuickChronos::getInstance()->user()->find($member['id']);
				if($user!=null) {
					$newProject->addMember($user);
				}
			}
		}
		$this->entityManager->persist($newProject);
		$this->entityManager->flush();
	}

	public function start($user, $project) {
		$existingActivity = $user->getCurrentActivity();
		if($existingActivity!=null) {
			return $existingActivity;
		}

		$newActivity = (new Activity())->forUser($user)->onProject($project);
		$user->setActiveProject($project);
		$this->entityManager->persist($newActivity);
		$this->entityManager->flush();
		$this->entityManager->refresh($newActivity);
		return $newActivity;
	}

	public function stop($user) {
		$activity = $user->getCurrentActivity();
		$activity->setStop(new \DateTime());
		$user->setActiveProject(null);
		$this->entityManager->flush();
		$this->entityManager->refresh($activity);
		return $activity;
	}

	public function getCurrentActivityForUserOnProject($user, $project) {
		$criteria = Criteria::create();
		$criteria
			->where($criteria->expr()->eq('project', $project))
			->andWhere($criteria->expr()->eq('user', $user))
			->andWhere($criteria->expr()->isNull('stop'));
		
		$activities = $this->activityRepository
			->matching($criteria)->getValues();
		
		if(count($activities)==0) return null;
		return $activities[0];
	}

	public function getLastActivityForUserOnProject($user, $project) {
		$criteria = Criteria::create();
		$criteria
			->where($criteria->expr()->eq('project', $project))
			->andWhere($criteria->expr()->eq('user', $user))
			->orderBy(array('stop'=> \Doctrine\Common\Collections\Criteria::DESC))
        	->setMaxResults(1);

        $activities = $this->activityRepository
        	->matching($criteria)->getValues();


        if(count($activities)==0) return null;
        return $activities[0];
	}
}
?>