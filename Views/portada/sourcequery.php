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
	$query = new \xPaw\SourceQuery\SourceQuery();

	try
	{
		// $query->Connect('45.235.99.146', $i, 1, \xPaw\SourceQuery\SourceQuery::SOURCE);
		$query->Connect('127.0.0.1', $i, 1, \xPaw\SourceQuery\SourceQuery::SOURCE);
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
