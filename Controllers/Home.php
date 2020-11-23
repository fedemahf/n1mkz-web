<?php namespace App\Controllers;

use SteamID;

class Home extends BaseController
{
	public function index()
	{
		$estaConectado = false;

		if($this->session->has('steam_id'))
		{
			$estaConectado = true;
			// preg_match_all('/^STEAM_(\d+):(\d+):(\d+)$/m', $this->session->get('steam_id'), $matches, PREG_SET_ORDER, 0);
			// $steamid = ($matches[0][1] << 56) | (0x100001 << 32) | ($matches[0][3] << 1) | $matches[0][2];
			// echo $steamid . PHP_EOL;
			$steamID64 = $this->session->get('steam_id');
			$steamidConstructor = new \SteamID($steamID64);
			// $steamID2 = $steamidConstructor->RenderSteam2();
			$steamAccountID = $steamidConstructor->GetAccountID();
			
			$steamID2 = sprintf(
				"STEAM_%d:%d:%d",
				(($steamID64 & 0b1111111100000000000000000000000000000000000000000000000000000000) >> 56),
				(($steamID64 & 0b0000000000000000000000000000000000000000000000000000000000000001)),
				(($steamID64 & 0b0000000000000000000000000000000011111111111111111111111111111110) >> 1)
			);

			// echo PHP_EOL . "<!-- steamID2: $steamID2 -->" . PHP_EOL;
			// echo PHP_EOL . "<!-- steamID64: $steamID64 -->" . PHP_EOL;
			// echo PHP_EOL . "<!-- steamAccountID: $steamAccountID -->" . PHP_EOL;

			// ----------------------------------------------------------------

			// Inicializar variable
			$dataContenido['usuario_vip_dias_restantes'] = -1;

			$row =
				$this
				->db
					->table('usuario_vip')
					->select('*')
					->select('(UNIX_TIMESTAMP(`fecha_final`) - UNIX_TIMESTAMP(NOW())) as `segundos_restantes`', FALSE)
					->where('usuario_id', $this->session->get('usuario_id'))
					->limit(1)
				->get()
				->getRow();

			if(isset($row))
			{
				// Comprobar que no haya caducado la suscripción
				if($row->segundos_restantes > 0)
				{
					$dataContenido['usuario_vip_dias_restantes'] = round($row->segundos_restantes / 86400);
				}
				else
				{
					// Guardar registro
					$this->db
						->table('registro_usuario_vip')
						->insert(
							array(
								'usuario_id' => $row->usuario_id,
								'fecha_inicio' => $row->fecha_inicio,
								'fecha_final' => $row->fecha_final
							)
						);

					// Retirar VIP
					$vipController = new \App\Controllers\Vip($this->db, $this->db_sourcemod_local);
					$vipController->desactivarVip($this->session->get('usuario_id'));
				}
			}

			// ----------------------------------------------------------------

			$row =
				$this
				->db_kztimer
					->table('playerrank')
					->where('steamid', $steamID2)
					->limit(1)
				->get()
				->getRow();
			
			if(isset($row))
			{
				$dataContenido['playerrank'] = $row;
				
				$dataContenido['playerrank']->position = $this
					->db_kztimer
						->table('playerrank')
						->selectCount('points')
						->where('points >=', $row->points)
					->get()
					->getRow()
					->points;
				
				$dataContenido['playerrank']->positionTotal = $this
					->db_kztimer
						->table('playerrank')
						->selectCount('points')
					->get()
					->getRow()
					->points;
				
				// $data['playerrank']->positionTotal = 0;
				// $data['playerrank']->position = 0;
			}
			
			// ----------------------------------------------------------------
			
			$dataContenido['usuario_rol_tier6'] = false;

			$row = $this->db_kztimer
				->query(
					"SELECT
						*
					FROM
						`playertimes`
					WHERE
						`steamid` = '" . $steamID2 . "' AND
						(
							`mapname` = 'kz_afterlife' OR
							`mapname` = 'kz_alien_city' OR
							`mapname` = 'kz_angina_final' OR
							`mapname` = 'kz_blackness' OR
							`mapname` = 'kz_chloroplast' OR
							`mapname` = 'kz_continuum' OR
							`mapname` = 'kz_gemischte_gefuehlslagen' OR
							`mapname` = 'kz_goquicklol_v2' OR
							`mapname` = 'kz_kzro_hardvalley' OR
							`mapname` = 'kz_lionheart' OR
							`mapname` = 'kz_mieszaneuczucia' OR
							`mapname` = 'kz_oloramasa' OR
							`mapname` = 'kz_p1' OR
							`mapname` = 'kz_purgatory' OR
							`mapname` = 'kz_retribution_v2_final' OR
							`mapname` = 'kz_shell' OR
							`mapname` = 'kz_slidebober' OR
							`mapname` = 'kz_slidemap' OR
							`mapname` = 'kz_slide_deee' OR
							`mapname` = 'kz_slide_svn_extreme' OR
							`mapname` = 'kz_slowrun_global_fix' OR
							`mapname` = 'kz_sp1_bloodyljs' OR
							`mapname` = 'kz_spacemario_h' OR
							`mapname` = 'kz_thrombosis' OR
							`mapname` = 'kz_zaloopazxc' OR
							`mapname` = 'skz_odious_v2'
						)
					GROUP BY
						`steamid`"
				)
				->getRow();

			if(isset($row))
			{
				$dataContenido['usuario_rol_tier6'] = true;
			}
			else
			{
				$row = $this->db_gokz
					->query(
						"SELECT
							`Times`.`SteamID32`,
							`Maps`.`Name`,
							`Players`.`Alias`
						FROM
							`Maps`,
							`MapCourses`,
							`Times`,
							`Players`
						WHERE
							(
								`Maps`.`Name` = 'kz_afterlife' OR
								`Maps`.`Name` = 'kz_alien_city' OR
								`Maps`.`Name` = 'kz_angina_final' OR
								`Maps`.`Name` = 'kz_blackness' OR
								`Maps`.`Name` = 'kz_chloroplast' OR
								`Maps`.`Name` = 'kz_continuum' OR
								`Maps`.`Name` = 'kz_gemischte_gefuehlslagen' OR
								`Maps`.`Name` = 'kz_goquicklol_v2' OR
								`Maps`.`Name` = 'kz_kzro_hardvalley' OR
								`Maps`.`Name` = 'kz_lionheart' OR
								`Maps`.`Name` = 'kz_mieszaneuczucia' OR
								`Maps`.`Name` = 'kz_oloramasa' OR
								`Maps`.`Name` = 'kz_p1' OR
								`Maps`.`Name` = 'kz_purgatory' OR
								`Maps`.`Name` = 'kz_retribution_v2_final' OR
								`Maps`.`Name` = 'kz_shell' OR
								`Maps`.`Name` = 'kz_slidebober' OR
								`Maps`.`Name` = 'kz_slidemap' OR
								`Maps`.`Name` = 'kz_slide_deee' OR
								`Maps`.`Name` = 'kz_slide_svn_extreme' OR
								`Maps`.`Name` = 'kz_slowrun_global_fix' OR
								`Maps`.`Name` = 'kz_sp1_bloodyljs' OR
								`Maps`.`Name` = 'kz_spacemario_h' OR
								`Maps`.`Name` = 'kz_thrombosis' OR
								`Maps`.`Name` = 'kz_zaloopazxc' OR
								`Maps`.`Name` = 'skz_odious_v2'
							)
							AND
								`MapCourses`.`MapID` = `Maps`.`MapID`
							AND
								`Times`.`MapCourseID` = `MapCourses`.`MapCourseID`
							AND
								`Times`.`SteamID32` = `Players`.`SteamID32`
							AND
								`Players`.`SteamID32` = '$steamAccountID'"
					)
					->getRow();

				if(isset($row))
				{
					$dataContenido['usuario_rol_tier6'] = true;
				}
			}

			// ----------------------------------------------------------------
			
			$dataContenido['usuario_rol_tier7'] = false;

			$row = $this->db_kztimer
				->query(
					"SELECT
						*
					FROM
						`playertimes`
					WHERE
						`steamid` = '$steamID2' AND
						(
							`mapname` = 'kz_erratum_v2' OR
							`mapname` = 'kz_unmake' OR
							`mapname` = 'kz_hemochromatosis' OR
							`mapname` = 'skz_makalaka'
						)
					GROUP BY
						`steamid`"
				)
				->getRow();

			if(isset($row))
			{
				$dataContenido['usuario_rol_tier7'] = true;
			}
			else
			{
				$row = $this->db_gokz
					->query(
						"SELECT
							`Times`.`SteamID32`,
							`Maps`.`Name`,
							`Players`.`Alias`
						FROM
							`Maps`,
							`MapCourses`,
							`Times`,
							`Players`
						WHERE
							(
								`Maps`.`Name` = 'kz_erratum_v2' OR
								`Maps`.`Name` = 'kz_unmake' OR
								`Maps`.`Name` = 'kz_hemochromatosis' OR
								`Maps`.`Name` = 'skz_makalaka'
							)
							AND
								`MapCourses`.`Course` = '0'
							AND
								`MapCourses`.`MapID` = `Maps`.`MapID`
							AND
								`Times`.`MapCourseID` = `MapCourses`.`MapCourseID`
							AND
								`Times`.`SteamID32` = `Players`.`SteamID32`
							AND
								`Players`.`SteamID32` = '$steamAccountID'
						GROUP BY
							`Times`.`SteamID32`"
					)
					->getRow();

				if(isset($row))
				{
					$dataContenido['usuario_rol_tier7'] = true;
				}
			}
		}
		
		$dataVip['estaConectado'] = $estaConectado;
		$dataContenido['estaConectado'] = $estaConectado;
		$dataContenido['session'] = $this->session;
		return view('templates/portada', ['dataContenido' => $dataContenido, 'dataVip' => $dataVip]);
	}

	public function login()
	{
		// helper('url');
		// $this->session = session();

		$steamauth['apikey'] = getenv('STEAM_API_KEY'); // Your Steam WebAPI-Key found at https://steamcommunity.com/dev/apikey
		$steamauth['domainname'] = parse_url(base_url(), PHP_URL_HOST); // The main URL of your website displayed in the login page

		// System stuff
		if (empty($steamauth['apikey'])) {die("<div style='display: block; width: 100%; background-color: red; text-align: center;'>SteamAuth:<br>Please supply an API-Key!<br>Find this in steamauth/SteamConfig.php, Find the '<b>\$steamauth['apikey']</b>' Array. </div>");}
		if (empty($steamauth['domainname'])) {$steamauth['domainname'] = $_SERVER['SERVER_NAME'];}

		try {
			$openid = new \LightOpenID($steamauth['domainname']);

			if (!$openid->mode) {
				$openid->identity = 'https://steamcommunity.com/openid';
				return redirect()->to($openid->authUrl());
			}
			elseif ($openid->mode == 'cancel')
			{
				// echo 'User has canceled authentication!';
				$this->session->setFlashdata('error', 'El usuario canceló la autenticación.');
			}
			else
			{
				if ($openid->validate())
				{
					preg_match("/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/", $openid->identity, $matches);
					$steam_id = $matches[1];
					$this->session->set('steam_id', $steam_id);
	
					$url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . $steamauth['apikey'] . "&steamids=" . $steam_id); 
					$content = json_decode($url, true);
					// $this->session->set('steam_steamid', $content['response']['players'][0]['steamid']);
					// $this->session->set('steam_communityvisibilitystate', $content['response']['players'][0]['communityvisibilitystate']);
					// $this->session->set('steam_profilestate', $content['response']['players'][0]['profilestate']);
					$this->session->set('steam_name', $content['response']['players'][0]['personaname']);
					// $this->session->set('steam_lastlogoff', $content['response']['players'][0]['lastlogoff']);
					$this->session->set('steam_profile_url', $content['response']['players'][0]['profileurl']);
					$this->session->set('steam_avatar_small', $content['response']['players'][0]['avatar']);
					$this->session->set('steam_avatar_medium', $content['response']['players'][0]['avatarmedium']);
					$this->session->set('steam_avatar_large', $content['response']['players'][0]['avatarfull']);
					// $this->session->set('steam_personastate', $content['response']['players'][0]['personastate']);
					// if (isset($content['response']['players'][0]['realname'])) { 
						   // $this->session->set('steam_realname', $content['response']['players'][0]['realname']);
					   // } else {
						   // $this->session->set('steam_realname', "Real name not given");
					// }
					// $this->session->set('steam_primaryclanid', $content['response']['players'][0]['primaryclanid']);
					// $this->session->set('steam_timecreated', $content['response']['players'][0]['timecreated']);
					// $this->session->set('steam_uptodate', time());

					$this->session->setFlashdata('success', 'Has iniciado sesión.');
					
					$row =
						$this
						->db
							->table('usuario')
							->select('id, nombre')
							->where('steam_id', $steam_id)
						->get()
						->getRow();

					if(isset($row))
					{
						$usuario_id = $row->id;
						
						// Si cambió el nombre, actualizar
						if($row->nombre != $this->session->get('steam_name'))
						{
							$this->db
								->table('usuario')
								->set('nombre', $this->session->get('steam_name'))
								->where('id', $usuario_id)
								->update();
						}
					}
					else
					{
						$this->db
							->table('usuario')
							->insert(
								array(
									'steam_id' => $steam_id,
									'nombre' => $this->session->get('steam_name')
								)
							);

						$usuario_id = $this->db->insertID();
					}

					$this->session->set('usuario_id', $usuario_id);

					$this->db
						->table('registro_ingreso')
						->insert(
							array(
								'usuario_id' => $usuario_id,
								'ip_address' => $_SERVER['REMOTE_ADDR']
							)
						);

					$row =
						$this
						->db
							->table('usuario_discord')
							->select('discord_id')
							->where('usuario_id', $usuario_id)
							->limit(1)
						->get()
						->getRow();

					if(isset($row))
					{
						// Guardar en sesión
						$this->session->set('discord_id', $row->discord_id);
					}
				}
				else
				{
					// echo "User is not logged in.\n";
					$this->session->setFlashdata('error', 'El usuario no está conectado.');
				}
			}
		}
		catch (ErrorException $e)
		{
			$this->session->setFlashdata('error', 'Error desconocido: '. $e->getMessage() .'.');
		}

		// return view('welcome_message');
		return redirect()->to('/');
	}

	public function logout()
	{
		// $this->session = session();

		if($this->session->has('steam_id'))
		{
			$this->session->destroy();
			$this->session->setFlashdata('success', 'Cerraste sesión con éxito.');
		}
		else
		{
			$this->session->setFlashdata('error', 'No había sesión que cerrar.');
		}

		return redirect()->to('/');
	}

	public function discord()
	{
		return redirect()->to('https://discord.gg/HanBQHg');
	}

	public function syuks()
	{
		return redirect()->to('https://www.youtube.com/watch?v=kqPFL90Gsls');
	}

	// public function prueba()
	// {
		// $email = \Config\Services::email();

		// $email->setFrom('admin@n1mkz.net', 'Your Name');
		// $email->setTo('autogris@gmail.com');
		// // $email->setCC('another@another-example.com');
		// // $email->setBCC('them@their-example.com');

		// $email->setSubject('Email Test');
		// $email->setMessage('Testing the email class.');

		// $email->send();
		// echo $email->printDebugger();
	// }
}
