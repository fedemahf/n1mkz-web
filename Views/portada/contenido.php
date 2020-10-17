<?php

// $session = session();

if ($session->getFlashdata('error'))
{
?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?=$session->getFlashdata('error'); ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
<?php
}

if ($session->getFlashdata('success'))
{
?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<?=$session->getFlashdata('success'); ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
<?php
}

if (!$estaConectado)
{
?>
				<!--<p><a href='/login'><img src='https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_02.png'></a></p>-->
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="card-title">Ni Una Menos KZ</h5>
						<p class="card-text">Somos una comunidad de Counter-Strike: Global Offensive en los modos de juego KZTimer y GOKZ.<br />La página web se encuentra en desarrollo. Ingresá con tu cuenta de Steam para acceder a todas las funciones disponibles.</p>
						<p class="card-text"><a href="/login" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 58" height="30" width="35" class="texticon" style="display: inline;height: 1.5rem;margin-right: .5rem;fill: currentColor;width: 1.5rem;"><path d="M50 26c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z"></path><path d="M55.918 27.364A7.959 7.959 0 0058 22c0-4.411-3.589-8-8-8-3.661 0-6.748 2.475-7.695 5.837L38.108 31.03a6.434 6.434 0 00-2.721.781l-20.47-8.389A7.5 7.5 0 007.5 17C3.364 17 0 20.364 0 24.5S3.364 32 7.5 32a7.424 7.424 0 004.144-1.274l20.592 8.44c.006.034-.002.067.008.101A6.52 6.52 0 0038.5 44c3.584 0 6.5-2.916 6.5-6.5 0-.175-.013-.348-.026-.52l10.68-9.223a.98.98 0 00.264-.393zM50 16c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6c0-.531.076-1.044.206-1.535l.23-.614c.019-.051.014-.103.025-.155A6.009 6.009 0 0150 16zM6.241 26.351a2.003 2.003 0 01-1.093-2.608 2.006 2.006 0 012.61-1.093l26.918 11.032c.19.186.433.283.69.283l2.891 1.185c.495.203.881.586 1.087 1.079s.208 1.036.005 1.531a1.997 1.997 0 01-2.608 1.092l-30.5-12.501zM7.5 30C4.468 30 2 27.532 2 24.5S4.468 19 7.5 19c2.293 0 4.274 1.425 5.089 3.467l-4.073-1.669a4.01 4.01 0 00-5.219 2.185 4.007 4.007 0 002.185 5.218l3.725 1.527A5.485 5.485 0 017.5 30zm31 12a4.505 4.505 0 01-3.505-1.703l.988.405a3.987 3.987 0 003.062-.013 3.968 3.968 0 002.155-2.172 4.006 4.006 0 00-2.184-5.22l-.694-.285c.06-.001.118-.012.178-.012 2.481 0 4.5 2.019 4.5 4.5S40.981 42 38.5 42zm1.671-10.774l2.377-6.338c1.161 2.985 4.058 5.111 7.449 5.112l-5.582 4.821a6.518 6.518 0 00-4.244-3.595z"></path></svg>Identificarse</a></p>
					</div>
				</div>
<?php
}
else
{
?>
				<div class="card mb-3">
					<div class="row no-gutters">
						<div class="col-md-2">
							<img src="<?=$session->get('steam_avatar_large')?>" class="card-img" alt="<?=$session->get('steam_name')?>">
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title">Bienvenide, <?=$session->get('steam_name')?>.</h5>
<?php
	if(isset($playerrank))
	{
?>
								<p class="card-text">Estadísticas KZT: ranking <?=$playerrank->position;?> de <?=$playerrank->positionTotal;?> con <?=$playerrank->points;?> puntos. Mapas PRO/TP/total: <?=$playerrank->finishedmapspro;?>/<?=$playerrank->finishedmapstp;?>/<?=$playerrank->finishedmaps;?>.</p>
<?php
	}
	else
	{
?>
								<p class="card-text">No se han encontrado estadísticas sobre KZ Timer.</p>
<?php
	}

	if($usuario_vip_dias_restantes != -1)
	{
		if($usuario_vip_dias_restantes == 0)
		{
?>
							<p class="card-text">&#x1F451; Tu membresía VIP finaliza en menos de 24 horas.</p>
<?php
		}
		else if($usuario_vip_dias_restantes == 1)
		{
?>
							<p class="card-text">&#x1F451; Te queda un día de membresía VIP.</p>
<?php
		}
		else
		{
?>
							<p class="card-text">&#x1F451; Te quedan <?=$usuario_vip_dias_restantes?> días de membresía VIP.</p>
<?php
		}
	}
?>
								<!--<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>-->
								<p class="card-text"><a class="btn btn-primary" role="button" href="/logout">Cerrar sesión</a></p>
							</div>
						</div>
					</div>
				</div>

				<!--<div class="card text-white bg-dark mb-3">-->
				<div class="card mb-3">
					<!--
					<div class="card-header">
						Featured
					</div>
					-->
					<div class="card-body">
						<h5 class="card-title">Discord</h5>
<?php
	if($session->has('discord_id'))
	{
		$discordController = new App\Controllers\Discord();
		$discord = $discordController->bot();
		$discord_id = $session->get('discord_id');

		try {
			settype($discord_id, "integer");
			$user = $discord->guild->getGuildMember(['guild.id' => $discordController->guild_id, 'user.id' => $discord_id]);

			// Si no tiene el rol de verificado, agregarlo
			if(!in_array($discordController->role_id_verificado, $user->roles))
			{
				$discord->guild->addGuildMemberRole(['guild.id' => $discordController->guild_id, 'user.id' => $discord_id, 'role.id' => $discordController->role_id_verificado]);
			}

			// Si es VIP...
			if($usuario_vip_dias_restantes > 0)
			{
				// Si no tiene rol de VIP, agregarlo
				if(!in_array($discordController->role_id_vip, $user->roles))
				{
					$discord->guild->addGuildMemberRole(['guild.id' => $discordController->guild_id, 'user.id' => $discord_id, 'role.id' => $discordController->role_id_vip]);
					$discord->channel->createMessage(['channel.id' => $discordController->channel_id_vip, 'content' => "¡Llegó <@{$discord_id}>! :sunglasses:"]);
				}
			}
			else
			{
				// Si tiene rol de VIP, eliminarlo
				if(in_array($discordController->role_id_vip, $user->roles))
				{
					$discord->guild->removeGuildMemberRole(['guild.id' => $discordController->guild_id, 'user.id' => $discord_id, 'role.id' => $discordController->role_id_vip]);
				}
			}

			// Si completó un mapa tier6...
			if($usuario_rol_tier6)
			{
				// Si no tiene rol de tier6, agregarlo
				if(!in_array($discordController->role_id_tier6, $user->roles))
				{
					$discord->guild->addGuildMemberRole(['guild.id' => $discordController->guild_id, 'user.id' => $discord_id, 'role.id' => $discordController->role_id_tier6]);
				}
			}
			else
			{
				// Si tiene rol de tier6, eliminarlo
				if(in_array($discordController->role_id_tier6, $user->roles))
				{
					$discord->guild->removeGuildMemberRole(['guild.id' => $discordController->guild_id, 'user.id' => $discord_id, 'role.id' => $discordController->role_id_tier6]);
				}
			}

			// Si completó un mapa tier7...
			if($usuario_rol_tier7)
			{
				// Si no tiene rol de tier7, agregarlo
				if(!in_array($discordController->role_id_tier7, $user->roles))
				{
					$discord->guild->addGuildMemberRole(['guild.id' => $discordController->guild_id, 'user.id' => $discord_id, 'role.id' => $discordController->role_id_tier7]);
				}
			}
			else
			{
				// Si tiene rol de tier7, eliminarlo
				if(in_array($discordController->role_id_tier7, $user->roles))
				{
					$discord->guild->removeGuildMemberRole(['guild.id' => $discordController->guild_id, 'user.id' => $discord_id, 'role.id' => $discordController->role_id_tier7]);
				}
			}
?>
						<p class="card-text">Tu cuenta de Discord está conectada con la página web. ¡Excelente! &#128522;</p>
						<button type="button" class="btn btn-danger" onclick="desvincularDiscord()">Desconectar Discord</button>
<?php
			// echo "<!---";
			// echo var_dump($user);
			// echo "-->";
		} catch (Exception $e) {
?>
						<p class="card-text">Tu cuenta de Discord está conectada con la página web. Accedé a <a href="/discord">n1mkz.net/discord</a> para unirte al servidor.</p>
						<!--<a href="/discord/desconectar" class="btn btn-danger">Desconectar Discord</a>-->
						<button type="button" class="btn btn-danger" onclick="desvincularDiscord()">Desconectar Discord</button>
<?php
			// echo "<p>" . $e->getMessage() . "</p>";
		}
	}
	else
	{
?>
				<!--<p>Tu cuenta de Discord no está conectada con la web. <a class="btn btn-primary" role="button" href="/discord/conectar">Vincular</a></p>-->
						<p class="card-text">Tu cuenta de Discord no está conectada con la página web.</p>
						<a href="/discord/conectar" class="btn btn-success">Conectar Discord</a>
<?php
	}
?>
					</div>
				</div>
<?php

	// $session->get('steam_id') // SteamID64 of the user
	// $session->get('steam_name') // Public name of the user
	// $session->get('steam_profile_url') // Link to the user's profile
	// $session->get('steam_avatar_small') // Address of the user's 32x32px avatar
	// $session->get('steam_avatar_medium') // Address of the user's 64x64px avatar
	// $session->get('steam_avatar_large') // Address of the user's 184x184px avatar

}

?>