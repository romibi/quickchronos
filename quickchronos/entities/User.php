<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;
require_once 'AbstractEntity.php';
use \Doctrine\Common\Collections as DoctrineCollections;

/**
* @Entity @Table(name="user")
**/
class User extends AbstractEntity implements \JsonSerializable {
	/** @Id @Column(type="guid") @GeneratedValue(strategy="UUID") **/
	protected $id;
	/** @Version @Column(type="integer") */
    private $version = 1;

    /** @Column(type="string", unique=true) **/
    protected $username;

    //no passwords yet

	/** @OneToMany(targetEntity="Activity", mappedBy="user") **/
    private $activities;

	/**
     * Many Users can be in Many Projects.
     * @ManyToMany(targetEntity="Project", mappedBy="members")
     */
    private $projects;

    /**
	  * @ManyToOne(targetEntity="Project")
	  * @JoinColumn(name="activeProjectId", referencedColumnName="id")
	  */
    protected $activeProject;

	public function __construct() {
		$this->activities = new DoctrineCollections\ArrayCollection();
		$this->projects = new DoctrineCollections\ArrayCollection();
	}

	public static function normalizedFromArray($array, $setDefaults=false) {
		if(isset($array['id'])) { $ret['id'] = $array['id']; }
		if(isset($array['username'])) { $ret['username'] = $array['username']; }
		//TODO: validate more!
		return $ret;
	}

	public function getId() {
		return $this->id;
	}

	public function getVersion() {
		return $this->version;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($name) {
		$this->username = $username;
	}

	public function getMembers() {
		return $this->members;
	}

	public function getActivities() {
		return $this->activities;
	}

	public function getActiveProject() {
		return $this->activeProject;
	}

	public function setActiveProject($project) {
		$this->activeProject = $project;
	}

	public function getCurrentActivity() {
		if($this->activeProject==null) return null;
		return $this->activeProject->getCurrentActivityForUser($this);
	}

	public function JsonSerialize()
	{
		return array(
			'id'=>$this->id,
			'username'=>$this->username,
			'_version'=>$this->version
		);
	}
}
?>