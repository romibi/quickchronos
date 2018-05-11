<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;
require_once 'AbstractEntity.php';

/**
* @Entity @Table(name="activity")
**/
class Activity extends AbstractEntity implements \JsonSerializable {
	/** @Id @Column(type="integer") @GeneratedValue **/
	protected $id;
	/** @Version @Column(type="integer") */
    private $version = 1;

    /** @Column(type="date") **/
    protected $start;
    /** @Column(type="date") **/
    protected $end;

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
    
	public function __construct($user, $project) {
		$this->user = $user;
		$this->project = $project;
	}

	public static function normalizedFromArray($array, $setDefaults=false) {
		if(isset($array['id'])) { $ret['id'] = $array['id']; }
		if(isset($array['start'])) { $ret['start'] = $array['start']; }
		elseif($setDefaults) {}
		if(isset($array['end'])) { $ret['end'] = $array['end']; }
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

	public function getEnd() {
		return $this->end;
	}

	public function setEnd($end) {
		$this->end = $end;
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
			$start = date_format($this->stop,'Y-m-d H:i:s');

		$ret = array(
			'id'=>$this->id,
			'_version'=>$this->version
		);

		if($this->project)
			$ret['_embedded']['project'] = $this->patient;
		if($this->user)
			$ret['_embedded']['user'] = $this->user;

		return $ret;
	}
}
?>