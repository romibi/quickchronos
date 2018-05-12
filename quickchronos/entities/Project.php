<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;
require_once 'AbstractEntity.php';
use \Doctrine\Common\Collections as DoctrineCollections;

/**
* @Entity @Table(name="project")
**/
class Project extends AbstractEntity implements \JsonSerializable {
	/** @Id @Column(type="string") **/
	protected $id;
	/** @Version @Column(type="integer") */
    private $version = 1;
	/** @Column(type="string") **/
	protected $name;

	/**
     * Many Users can be in Many Projects.
     * @ManyToMany(targetEntity="User", inversedBy="projects")
     * @JoinTable(name="users_project",
     *      joinColumns={@JoinColumn(name="projectId", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="userId", referencedColumnName="id")}
     *      )
     */
    private $members;

    /** @OneToMany(targetEntity="Activity", mappedBy="project") **/
    private $activities;

	public function __construct() {
		$this->members = new DoctrineCollections\ArrayCollection();
		$this->activities = new DoctrineCollections\ArrayCollection();
	}

	public static function normalizedFromArray($array, $setDefaults=false) {
		if(isset($array['id'])) { $ret['id'] = $array['id']; }
		if(isset($array['name'])) { $ret['name'] = $array['name']; }
		//TODO: validate more!
		return $ret;
	}

	public function getId() {
		return $this->id;
	}

	public function getVersion() {
		return $this->version;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getMembers() {
		return $this->members;
	}

	public function addMember($user) {
		$this->members->add($user);
	}

	public function getActivities() {
		return $this->activities;
	}

	public function getCurrentActivityForUser($user) {
		return QuickChronos::getInstance()->project()->getCurrentActivityForUserOnProject($user, $this);
	}

	public function getLastActivityForUser($user) {
		$activity = $this->getCurrentActivityForUser($user);
		if($activity!=null) {
			return $activity;
		}
		return QuickChronos::getInstance()->project()->getLastActivityForUserOnProject($user, $this);
	}

	public function JsonSerialize()
	{
		return array(
			'id'=>$this->id,
			'name'=>$this->name,
			'_version'=>$this->version
		);
	}
}
?>