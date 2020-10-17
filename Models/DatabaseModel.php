<?php namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class DatabaseModel
{
	public $web;
	public $kztimer;
	public $gokz;
	public $sourcemod_local;

	public function __construct()
	{
		$this->web = \Config\Database::connect();
		$this->kztimer = \Config\Database::connect('kztimer');
		$this->gokz = \Config\Database::connect('gokz');
		$this->sourcemod_local = \Config\Database::connect('sourcemod_local');
	}
}