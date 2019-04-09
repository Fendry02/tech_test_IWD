<?php

class Survey implements Serializable
{
	public $name;
	public $code;

	function __construct(String $name, String $code) {
		$this->name = $name;
		$this->code = $code;
	}	

	/**
	 * Retourne le nom
	 * Return String
	 */
	public function getName(): String {
		return $this->name;
	}

	/**
	 * Retourne le code
	 * Return String
	 */
	public function getCode(): String {
		return $this->code;
	}

	/**
	 * Sérialize l'objet
	 */
	public function serialize(): array
	{
		return [
			"name" => $this->name,
			"code" => $this->code
		];
	}

	public function unserialize($serialized)
	{
		
	}
}
?>