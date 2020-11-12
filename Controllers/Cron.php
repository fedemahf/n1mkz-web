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

	public function refrescar_discord_world_record()
	{
		set_time_limit(0);

		$usuarioLista = array();
		$query = $this->db->query('SELECT `usuario`.`steam_id` FROM `usuario`, `usuario_discord` WHERE `usuario`.`id` = `usuario_discord`.`usuario_id`');

		foreach($query->getResult() as $row)
		{
			$usuarioLista[] = $row->steam_id;
		}

		var_dump($usuarioLista);
		
		// try {
		// 	$ch = curl_init("http://kztimerglobal.com/api/v2.0/records/top/world_records?limit=2");
		// 	curl_setopt_array($ch, array(
		// 		CURLOPT_RETURNTRANSFER    => true,     // return web page
		// 		CURLOPT_HEADER            => false,    // don't return headers
		// 		CURLOPT_FOLLOWLOCATION    => true,     // follow redirects
		// 		CURLOPT_USERAGENT      => "n1mkz.net updating world records",
		// 		CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
		// 		CURLOPT_TIMEOUT        => 120,      // timeout on response
		// 		CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
		// 		CURLOPT_SSL_VERIFYPEER => false,    // don't verify the peer's SSL certificate
		// 		CURLOPT_SSL_VERIFYHOST => false        // don't verify the certificate's name against host
		// 	));
		// 	$map = json_decode(curl_exec($ch));
		// 	curl_close($ch);
	
		// 	var_dump($map);
		// 	echo PHP_EOL .  PHP_EOL .  PHP_EOL;
		// 	echo $map[0]->steamid64;
		// } catch (Exception $e) {
		// 	echo "Error $value: $e";
		// }
	}
}
