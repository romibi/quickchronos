<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;
require_once 'AbstractEntity.php';
use \Doctrine\Common\Collections as DoctrineCollections;

/**
* @Entity @Table(name="activity")
**/
class Activity extends AbstractEntity implements \JsonSerializable {
	/** @Id @Column(type="integer") @GeneratedValue **/
	protected $id;
	/** @Version @Column(type="integer") */
    private $version = 1;

    /** @Column(type="datetime") **/
    protected $start;
    /** @Column(type="datetime", nullable=true) **/
    protected $stop = null;

    /**
	  * @ManyToOne(targetEntity="Project")
	  * @JoinColumn(name="projectId", referencedColumnName="id")
	  */
    protected $project;

    /**
	  * @ManyToOne(targetEntity="User")
	  * @JoinColumn(name="userId", referencedColumnName="id")
	  */
    protected $user;
    
	public function __construct() {
		 $this->start = new \DateTime();
	}

	public function forUser($user) {
		if($this->id!=null) throw new \Exception("Error Processing Request", 1);
		$this->user = $user;
		return $this;
	}

	public function onProject($project) {
		if($this->id!=null) throw new \Exception("Error Processing Request", 1);
		$this->project = $project;
		return $this;
	}

	public static function normalizedFromArray($array, $setDefaults=false) {
		if(isset($array['id'])) { $ret['id'] = $array['id']; }
		if(isset($array['start'])) { $ret['start'] = $array['start']; }
		elseif($setDefaults) {}
		if(isset($array['stop'])) { $ret['stop'] = $array['stop']; }
		if(isset($array['projectId'])) { $ret['project'] = QuickChronos::getInstance()->project()->get($array['projectId']); }
		if(isset($array['userId'])) { $ret['user'] = QuickChronos::getInstance()->project()->get($array['userId']); }

		//TODO: validate more!
		return $ret;
	}

	public function getId() {
		return $this->id;
	}

	public function getVersion() {
		return $this->version;
	}

	public function getStart() {
		return $this->start;
	}

	public function setStart($start) {
		$this->start = $start;
	}

	public function getStop() {
		return $this->stop;
	}

	public function setStop($stop) {
		$this->stop = $stop;
	}

	public function getProject() {
		return $this->project;
	}

	public function getUser() {
		return $this->user;
	}

	public function JsonSerialize()
	{
		$start = null;
		if($this->start)
			$start = date_format($this->start,'Y-m-d H:i:s');

		$stop = null;
		if($this->stop)
			$stop = date_format($this->stop,'Y-m-d H:i:s');

		$ret = array(
			'id'=>$this->id,
			'start'=>$start,
			'stop'=>$stop,
			'_version'=>$this->version
		);

		if($this->project)
			$ret['_embedded']['project'] = $this->project;
		if($this->user)
			$ret['_embedded']['user'] = $this->user;

		return $ret;
	}
}
?>