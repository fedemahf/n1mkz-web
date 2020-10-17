<?php namespace App\Controllers;

class Cron extends BaseController
{
	public function index()
	{
		$vipController = new \App\Controllers\Vip($this->db, $this->db_sourcemod_local);

		$query =
			$this->db
				->table('usuario_vip')
				->where('(UNIX_TIMESTAMP(`fecha_final`) - UNIX_TIMESTAMP(NOW())) <=', "0", false)
			->get();

		foreach($query->getResult() as $row)
		{
			$this->db
				->table('registro_usuario_vip')
				->insert(
					array(
						'usuario_id' => $row->usuario_id,
						'fecha_inicio' => $row->fecha_inicio,
						'fecha_final' => $row->fecha_final
					)
				);

			$vipController->desactivarVip($row->usuario_id);
		}
	}
}
