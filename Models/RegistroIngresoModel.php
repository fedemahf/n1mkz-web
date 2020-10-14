<?php namespace App\Models;

use CodeIgniter\Model;

class RegistroIngresoModel extends Model
{
	protected $table = 'registro_ingreso';
	protected $allowedFields = ['steam_id', 'ip'];
}

