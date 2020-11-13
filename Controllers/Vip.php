<?php namespace App\Controllers;

use CodeIgniter\Database\ConnectionInterface;

class Vip extends BaseController
{
	protected $db_web;
	protected $db_sourcemod_local;

	public function __construct()
	{
		$db = model('App\Models\DatabaseModel');
		$this->db_web =& $db->web;
		$this->db_sourcemod_local =& $db->sourcemod_local;
	}

    public function desactivarVip($usuario_id)
	{
		// Obtener steam_id a partir del usuario_id
		$row = $this->db_web
			->table('usuario')
			->select('steam_id')
			// ->select('steam_id64')
			->where('id', $usuario_id)
			->get()
			->getRow();

		// Si se obtuvo el steam_id...
		if(isset($row))
		{
			// Guardar steamID y steamID64
			$admin_id = 0;
			$steamID64 = $row->steam_id;
			$steamID = sprintf(
				"STEAM_%d:%d:%d",
				(($steamID64 & 0b1111111100000000000000000000000000000000000000000000000000000000) >> 56),
				(($steamID64 & 0b0000000000000000000000000000000000000000000000000000000000000001)),
				(($steamID64 & 0b0000000000000000000000000000000011111111111111111111111111111110) >> 1)
			);

			// Obtener admin_id de sm_admins
			$row = $this->db_sourcemod_local
				->table('sm_admins')
				->select('id')
				->where('authtype', 'steam')
				->where('identity', $steamID)
				->get()
				->getRow();

			// Si había admin_id...
			if(isset($row))
			{
				// Guardar valor
				$admin_id = $row->id;
			}

			// Comprobar si tiene armas modificadas
			$row = $this->db_sourcemod_local
				->table('weapons')
				->select('*')
				->where('steamid', $steamID)
				->get()
				->getRow();

			// Si tiene armas modificadas...
			if(isset($row))
			{
				// Eliminar posibles valores obsoletos en db
				$this->db_sourcemod_local->table('weapons_disabled')->delete(['steamid' => $steamID]);
				$this->db_sourcemod_local->table('weapons_timestamps')->delete(['steamid' => $steamID]);
				
				// Archivar valores activos
				$this->db_sourcemod_local->query("INSERT INTO `weapons_disabled` SELECT * FROM `weapons` WHERE `steamid`='$steamID'");
				$this->db_sourcemod_local->table('weapons')->delete(['steamid' => $steamID]);
			}

			// Eliminar filas asociadas a la membresía VIP
			$this->db_web->table('usuario_vip')->delete(['usuario_id' => $usuario_id]);
			if($admin_id != 0) $this->db_sourcemod_local->table('sm_admins_groups')->delete(['admin_id' => $admin_id, 'group_id' => 2]);
			$this->db_sourcemod_local->table('sm_admins')->delete(['identity' => $steamID, 'flags' => 'a']);
		}
    }
}