<?php
// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt).
namespace ch\romibi\quickchronos;

abstract class AbstractEntity {
	protected function __construct() {}

	public static function fromArray($array) {
		$vals = static::normalizedFromArray($array, true);
		//is this possible to do nicer?
		$reflectionClass = new \ReflectionClass(get_called_class());
		$entity = $reflectionClass->newInstance();
		
		$entity->updateFromArray($vals, false);
		return $entity;
	}

	public function updateFromArray($array, $validate = true) {
		$vals = $array;
		if($validate) {
			$vals = static::normalizedFromArray($array);
		}
		foreach ($vals as $key => $value) {
			$this->$key = $value;
		}
	}
	
	public abstract static function normalizedFromArray($array, $setDefaults=false);

	public function __toString() {
		return json_encode($this);
	}
}