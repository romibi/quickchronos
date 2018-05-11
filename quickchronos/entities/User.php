<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;
require_once 'AbstractEntity.php';

/**
* @Entity @Table(name="user")
**/
class User extends AbstractEntity implements \JsonSerializable {
	/** @Id @Column(type="integer") @GeneratedValue(strategy="UUID") **/
	protected $id;
	/** @Version @Column(type="integer") */
    private $version = 1;

    /** @Column(type="string") **/
    protected $username;

    //no passwords yet

	/** @OneToMany(targetEntity="Activity", mappedBy="user") **/
    private $activities;

	/**
     * Many Users can be in Many Projects.
     * @ManyToMany(targetEntity="Project", mappedBy="members")
     */
    private $projects;

	public function __construct($username) {
		$this->username = $username;
		$this->activities = new ArrayCollection();
		$this->projects = new ArrayCollection();
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

	public function getActivities() {
		return $this->activities;
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