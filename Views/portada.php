<?php use xPaw\SourceQuery\SourceQuery; ?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Servidores de Counter-Strike: Global Offensive.">
		<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
		<meta name="generator" content="Jekyll v4.1.1">
		<title>Ni Una Menos KZ</title>
		<link rel="icon" type="image/png" href="/favicon.ico">

		<!-- Bootstrap CSS -->
		<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">-->
		<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/slate/bootstrap.min.css" integrity="sha384-8iuq0iaMHpnH2vSyvZMSIqQuUnQA7QM+f6srIdlgBrTSEyd//AWNMyEaSF2yPzNQ" crossorigin="anonymous">-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/superhero/bootstrap.min.css" integrity="sha384-HnTY+mLT0stQlOwD3wcAzSVAZbrBp141qwfR4WfTqVQKSgmcgzk+oP0ieIyrxiFO" crossorigin="anonymous">
		<!--<link rel="stylesheet" href="<?=base_url('assets/bootswatch/4.5.2/slate/bootstrap.min.css')?>">-->
		<link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">

		<style>
			.bd-placeholder-img {
				font-size: 1.125rem;
				text-anchor: middle;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
			}

			@media (min-width: 768px) {
				.bd-placeholder-img-lg {
					font-size: 3.5rem;
				}
			}

			/* body {
				padding-top: 5rem;
			} */

			.starter-template {
				padding: 3rem 1.5rem;
				/* text-align: center; */
			}

			.themed-grid-col {
				padding-top: 15px;
				padding-bottom: 15px;
				/* background-color: rgba(86, 61, 124, .15); */
				/* border: 1px solid rgba(86, 61, 124, .2); */
				background-color: #4e5d6c;
				border: 1px solid rgba(0,0,0,0.125);
			}
		</style>

		<!-- Custom styles for this template -->
		<!-- <link href="starter-template.css" rel="stylesheet"> -->
	</head>
	<body>

		<!--
		<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
			<a class="navbar-brand" href="#">Navbar</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarsExampleDefault">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown01">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
			</ul>
				<form class="form-inline my-2 my-lg-0">
					<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
					<button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
				</form>
			</div>
		</nav>
		-->

		<main role="main" class="container">
			<div class="starter-template">
				<!--<h1>Bootstrap starter template</h1>-->
				<!--<p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>-->
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
		if($usuario_vip_dias_restantes > 0)
		{
			if($usuario_vip_dias_restantes == 1)
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
	}
	else
	{
?>
								<p class="card-text">No se han encontrado estadísticas sobre KZ Timer.</p>
<?php
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
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="card-title">VIP</h5>
						<p class="card-text">Si disfrutás de los servidores, por favor ¡considerá hacer una colaboración! Como agradecimiento, obtendrás los beneficios listados a continuación.</p>
						<ul>
							<li><b>Comandos !ws, !knife.</b> Todos los skins de CS:GO estarán a tu disposición.</li>
							<li><b>Comando !extend.</b> Extiende un mapa durante un máximo de 20 minutos. Una sola vez por mapa para cada jugador, y cinco veces por mapa para todos los jugadores VIP.</li>
							<li><b>Bind +noclip.</b> Posibilidad de volar por el mapa en los servidores KZTimer.</li>
							<li><b>Slot reservado.</b> Acceso a los servidores aunque estén llenos, siempre y cuando no estén ocupados los slots reservados.</li>
							<li><b>Etiqueta exclusiva.</b> Etiqueta exclusiva en el nombre en los servidores KZTimer.</li>
							<li><b>Rol en Discord.</b> Se te asignará un rol especial y desbloquearás una categoría de canales exclusiva para usuarios VIP.</li>
							<li><b>¡Y más!</b> Así como el !extend —cuyo funcionamiento es exclusivo de nuestros servidores—, en un futuro podríamos agregar más beneficios VIP. ¿Tenés alguna idea? ¡Compartila en Discord!</li>
						</ul>
						<p class="card-text">Una vez abonado el pago, el VIP se activará automáticamente, tanto en los servidores de CS:GO como en Discord. Si estás conectado en un servidor de CS:GO, es posible que debas reconectar o esperar que cambie el mapa.</p>
						<div class="card-deck mb-1 text-center">
							<div class="card shadow-sm bg-light text-dark">
								<div class="card-header">
									<h4 class="my-0 font-weight-normal">VIP 1 mes</h4>
								</div>
								<div class="card-body">
									<h1 class="card-title pricing-card-title">$100</h1>
									<a class="btn btn-lg btn-block btn-primary" <?=$estaConectado ? "href=\"/mercadopago/comprar/1\"" : "onclick=\"btnComprarVip()\""?>>Comprar</a>
								</div>
							</div>
							<div class="card shadow-sm bg-light text-dark">
								<div class="card-header">
									<h4 class="my-0 font-weight-normal">VIP 3 meses</h4>
								</div>
								<div class="card-body">
									<h1 class="card-title pricing-card-title">$275</h1>
									<a class="btn btn-lg btn-block btn-primary" <?=$estaConectado ? "href=\"/mercadopago/comprar/2\"" : "onclick=\"btnComprarVip()\""?>>Comprar</a>
								</div>
							</div>
							<div class="card shadow-sm bg-light text-dark">
								<div class="card-header">
									<h4 class="my-0 font-weight-normal">VIP 6 meses</h4>
								</div>
								<div class="card-body">
									<h1 class="card-title pricing-card-title">$500</h1>
									<a class="btn btn-lg btn-block btn-primary" <?=$estaConectado ? "href=\"/mercadopago/comprar/3\"" : "onclick=\"btnComprarVip()\""?>>Comprar</a>
								</div>
							</div>
						</div>
					</div>
				</div>
<?php

// if (isset($sourceQuery))
// {
	// foreach($sourceQuery as $server)
	// {
		// var_dump($server);
	// }
// }

$tablaCreada = false;
$totalPlayers = 0;
$totalBots = 0;
$totalMaxPlayers = 0;
$servidores = 0;

for ($i = 27016; $i <= 27022; $i++)
{
	$query = new SourceQuery();

	try
	{
		$query->Connect('45.235.99.146', $i, 1, SourceQuery::SOURCE);
		$serverInfo = $query->GetInfo();

		if($serverInfo !== false)
		{
			if(!$tablaCreada)
			{
?>
				<div class="container">
<?php
				$tablaCreada = true;
			}

			// echo "<!--" . PHP_EOL;
			// var_dump($serverInfo);
			// echo PHP_EOL;
			// var_dump($query);
			// echo "-->" . PHP_EOL;

			$totalPlayers += $serverInfo['Players'];
			$totalBots += $serverInfo['Bots'];
			$totalMaxPlayers += $serverInfo['MaxPlayers'];
			$servidores++;
?>
					<div class="row">
						<div class="col-xl-2 themed-grid-col"><a href="steam://connect/45.235.99.146:<?=$i?>">cs.n1mkz.net:<?=$i?></a></div>
						<div class="col-xl themed-grid-col"><?=$serverInfo['HostName']?></div>
						<div class="col-xl-3 themed-grid-col"><?=basename($serverInfo['Map'])?></div>
						<div class="col-xl-2 themed-grid-col"><?=$serverInfo['Players']?> (<?=$serverInfo['Bots']?>) / <?=$serverInfo['MaxPlayers']?></div>
						<!--<div class="col-xl themed-grid-col"><?=$serverInfo['Version']?></div>-->
					</div>
<?php
			// foreach ($query->GetPlayers() as $player)
			// {

					// <p>$player['Name'] | $player['TimeF']<p>

			// }
		}
	}
	catch(Exception $e)
	{
		log_message('critical', '[Test_SourceQuery] ' . $e->getMessage());
	}
	finally
	{
		$query->Disconnect();
	}
}

if($tablaCreada)
{
?>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xl themed-grid-col">Jugadores: <?=$totalPlayers?> (<?=$totalBots?> bots)</div>
						<div class="col-xl themed-grid-col">Slots: <?=$totalMaxPlayers?></div>
						<div class="col-xl themed-grid-col">Servidores: <?=$servidores?></div>
					</div>
				</div>
<?php
}
?>
			<div class="container">
				<div class="row text-center">
					<div class="col mt-4">
						<a href="https://discord.gg/HanBQHg" target="_blank">
							<i class="btn cib-discord" style="font-size: 5rem;"></i>
						</a>
					</div>
					<div class="col mt-4">
						<a href="https://steamcommunity.com/groups/n1mkz" target="_blank">
							<i class="btn cib-steam" style="font-size: 5rem;"></i>
						</a>
					</div>
					<div class="col mt-4">
						<a href="https://twitter.com/n1mkz" target="_blank">
							<i class="btn cib-twitter" style="font-size: 5rem;"></i>
						</a>
					</div>
				</div>
			</div>
		</main><!-- /.container -->

		<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
		<!-- <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script> -->

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
		<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
		<script>
		function desvincularDiscord() {
			Swal.fire({
			  title: '¿Estás segure?',
			  /*text: "¡Si desvinculás tu cuenta podrías perder algunos roles!",*/
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Sí, desvincular',
			  cancelButtonText: 'Cancelar'
			}).then((result) => {
			  if (result.value) {
				window.location.href = "/discord/desconectar";
			  }
			})
		}

		function btnComprarVip() {
			Swal.fire({
				icon: 'error',
				title: '¡No te identificaste!',
				text: 'Debés identificarte para adquirir tu membresía VIP.'
			})
			return false;
		}
		</script>
	</body>
</html>
