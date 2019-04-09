<?php

class Question extends Survey implements Serializable
{
	public $products = [
		"Product 1" => 0, 
		"Product 2" => 0,
		"Product 3" => 0,
		"Product 4" => 0,
		"Product 5" => 0,
		"Product 6" => 0
	];
	public $nbProducts = 0;
	public $dates = [];

	/**
	 * Constructeur de parent survey
	 */
	function __construct(String $name, String $code)
	{
		parent::__construct($name, $code);
	}

	/**
	 * + 1 au compteur pour le produit dans le tableau des produits
	 * String $product
	 */
	function addProduct(String $product): void
	{
		if (in_array($product, $this->products)) $this->products[$product]++;
	}

	/**
	 * Vérifie l'existence d'un produit dans le tableau des produits
	 * String $product
	 * Return bool
	 */
	function hasProduct(String $product): bool
	{
		return in_array($product, $this->products);
	}

	/**
	 * Retourne le tableau des produits
	 */
	function getProducts(): array
	{
		return $this->products;
	}

	/**
	 * Défini le nombre de produits
	 * Integer $nbProducts
	 */
	function setNbProducts(Int $nbProducts): void
	{
		$this->nbProducts = $nbProducts;
	}

	/**
	 * Ajoute $nbProducts aux nombre de produit de la classe
	 * Integer $nbProducts
	 */
	function addNbProducts(Int $nbProducts): void
	{
		$this->nbProducts += $nbProducts;
	}

	/**
	 * Retourne le nombre de produits
	 */
	function getNbProducts(): Int
	{
		return $this->nbProducts;
	}

	/**
	 * Ajoute une date au tableau des dates
	 */
	function addDate(DateTime $date): void
	{
		$this->dates[] = $date;
	}

	/**
	 * Retourne le tableau de date
	 */
	function getDates(): array
	{
		$dates = [];

		foreach($this->dates as $date) 
		{
			$dates[] = $date->format("Y-m-d H:i:s");
		}
		return $dates;
	}

	function serialize(): array
	{
		return [
			"name" => $this->name,
			"code" => $this->code,
			"nbProducts" => $this->nbProducts,
			"dates" => $this->getDates(),
			"products" => $this->products
		];
	}
}
?>