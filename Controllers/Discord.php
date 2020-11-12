<?php namespace App\Controllers;

use RestCord\DiscordClient;

class Discord extends BaseController
{
	public $guild_id = 729201502320590902;
	public $role_id_verificado = 743529133480345622;
	public $role_id_vip = 751975378968641617;
	public $role_id_tier6 = 736054232389779498;
	public $role_id_tier7 = 749315682780577843;
	public $role_id_world_record = 776560731653931019;
	public $channel_id_vip = 751983414797795348;

	// public function index()
	// {
		// return redirect()->to('https://discord.gg/HanBQHg');
	// }

	public function bot()
	{
		$discord = new DiscordClient(['token' => getenv('DISCORD_TOKEN')]);
		return $discord;
	}
	
	public function existeMiembro($discord_id)
	{
        try {
			settype($discord_id, "integer");
            $this->bot()->guild->getGuildMember(['guild.id' => $this->guild_id, 'user.id' => $discord_id]);
            return true;
        } catch (Exception $e) {
            return false;
        }
	}

	// public function establecerVerificado($discord_id, $verificado = true)
	// {
    //     try {
	// 		settype($discord_id, "integer");
	// 		$discord = $this->bot();
    //         $user = $discord->guild->getGuildMember(['guild.id' => $this->guild_id, 'user.id' => $discord_id]);
	// 		$tieneRol = false;
			
	// 		foreach($user->roles as $role_id)
	// 		{
	// 			if($role_id == $this->role_id_verificado)
	// 			{
	// 				$tieneRol = true;
	// 				break;
	// 			}
	// 		}
			
	// 		if($tieneRol)
	// 		{
	// 			if(!$verificado)
	// 			{
	// 				$discord->guild->removeGuildMemberRole(['guild.id' => $this->guild_id, 'user.id' => $discord_id, 'role.id' => $this->role_id_verificado]);
	// 			}
	// 		}
	// 		else
	// 		{
	// 			if($verificado)
	// 			{
	// 				$discord->guild->addGuildMemberRole(['guild.id' => $this->guild_id, 'user.id' => $discord_id, 'role.id' => $this->role_id_verificado]);
	// 			}
	// 		}
			
    //         return true;
    //     } catch (Exception $e) {
    //         return false;
    //     }
	// }

	public function conectar()
	{
		if (!$this->session->has('steam_id'))
		{
			$this->session->setFlashdata('error', 'Debés ingresar en tu cuenta de Steam.');
			return redirect()->to('/');
		}

		if ($this->session->has('discord_id'))
		{
			$this->session->setFlashdata('error', 'Ya tenés una cuenta vinculada.');
			return redirect()->to('/');
		}

		$provider = new \Wohali\OAuth2\Client\Provider\Discord([
			'clientId' => getenv('DISCORD_BOT_CLIENT_ID'),
			'clientSecret' => getenv('DISCORD_BOT_CLIENT_SECRET'),
			'redirectUri' => base_url('discord/conectar')
		]);

		if (!isset($_GET['code']))
		{
			// Step 1. Get authorization code
			$options = [
				'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
				'scope' => ['identify'] // array or string
			];
			$authUrl = $provider->getAuthorizationUrl($options);
			//$_SESSION['oauth2state'] = $provider->getState();
			$this->session->set('oauth2state', $provider->getState());
			// header('Location: ' . $authUrl);
			return redirect()->to($authUrl);

		// Check given state against previously stored one to mitigate CSRF attack
		}
		elseif (empty($_GET['state']) || ($_GET['state'] !== $this->session->get('oauth2state')))
		{
			$this->session->remove('oauth2state');
			// unset($_SESSION['oauth2state']);
			// exit('Invalid state');

			$this->session->setFlashdata('error', 'Estado OAuth 2.0 inválido. Vuelve a intentarlo.');
			return redirect()->to('/');
		}
		else
		{
			// Step 2. Get an access token using the provided authorization code
			$token = $provider->getAccessToken('authorization_code', [
				'code' => $_GET['code']
			]);

			// // Show some token details
			// echo '<h2>Token details:</h2>';
			// echo 'Token: ' . $token->getToken() . "<br/>";
			// echo 'Refresh token: ' . $token->getRefreshToken() . "<br/>";
			// echo 'Expires: ' . $token->getExpires() . " - ";
			// echo ($token->hasExpired() ? 'expired' : 'not expired') . "<br/>";

			// Step 3. (Optional) Look up the user's profile with the provided token
			try {

				// $user = $provider->getResourceOwner($token);

				// echo '<h2>Resource owner details:</h2>';
				// printf('Hello %s#%s!<br/><br/>', $user->getUsername(), $user->getDiscriminator());
				// var_export($user->toArray());
				
				// Obtener ID de Discord
				$discord_id = $provider->getResourceOwner($token)->getId();
				
				// Guardar en sesión
				$this->session->set('discord_id', $discord_id);

				// Guardar en la base de datos
				$this->db->table('usuario_discord')->insert(
					array(
						'usuario_id' => $this->session->get('usuario_id'),
						// 'steam_id' => $this->session->get('steam_id'),
						'discord_id' => $discord_id,
						'ip_address' => $_SERVER['REMOTE_ADDR']
					)
				);
				
				// $this->establecerVerificado($discord_id, true);

				// $this->session->setFlashdata('success', 'Vinculaste la cuenta con éxito. Discord: '. $discord_id .'. Steam: '. $this->session->get('steam_id') .'.');
				$this->session->setFlashdata('success', 'Vinculaste la cuenta con éxito.');

			} catch (Exception $e) {
				// Failed to get user details
				$this->session->setFlashdata('error', 'Error desconocido: '. $e->getMessage() .'.');
			}
		}

		return redirect()->to('/');
		// return view('portada');
	}
	
	public function desconectar()
	{
		if($this->session->has('discord_id'))
		{
			$discord = $this->bot();
			$discord_id = $this->session->get('discord_id');

			try {
				settype($discord_id, "integer");
				// Obtener usuario
				$user = $discord->guild->getGuildMember(['guild.id' => $this->guild_id, 'user.id' => $discord_id]);

				// Recorrer roles del usuario
				foreach($user->roles as $role_id)
				{
					// Si tiene verificado...
					if($role_id == $this->role_id_verificado)
					{
						// Eliminarlo
						$discord->guild->removeGuildMemberRole(['guild.id' => $this->guild_id, 'user.id' => $discord_id, 'role.id' => $this->role_id_verificado]);
					}

					// Si tiene VIP...
					if($role_id == $this->role_id_vip)
					{
						// Eliminarlo
						$discord->guild->removeGuildMemberRole(['guild.id' => $this->guild_id, 'user.id' => $discord_id, 'role.id' => $this->role_id_vip]);
					}
				}
			} catch (\Exception $e) {
				// No está en guild
			}

			// Eliminar de la base de datos
			$this->db->table('usuario_discord')->delete(['discord_id' => $discord_id]);
		
			// Eliminar de sesión
			$this->session->remove('discord_id');

			// Informar usuario
			$this->session->setFlashdata('success', 'Desvinculaste la cuenta de Discord con éxito.');
		}
		else
		{
			$this->session->setFlashdata('error', 'Tu cuenta no estaba vinculada a Discord.');
		}

		return redirect()->to('/');
		// return view('portada');
	}
}
