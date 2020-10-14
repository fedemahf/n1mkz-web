<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	public function login()
	{
		$pathSteamAuth = VENDORPATH . 'smith197/steamauthentication/steamauth/';
		require_once $pathSteamAuth . 'openid.php';
		try {
			require_once $pathSteamAuth . 'SteamConfig.php';
			$openid = new \LightOpenID($steamauth['domainname']);

			if(!$openid->mode) {
				$openid->identity = 'https://steamcommunity.com/openid';
				header('Location: ' . $openid->authUrl());
			} elseif ($openid->mode == 'cancel') {
				echo 'User has canceled authentication!';
			} else {
				if($openid->validate()) { 
					$id = $openid->identity;
					$ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
					preg_match($ptn, $id, $matches);

					$_SESSION['steamid'] = $matches[1];
					if (!headers_sent()) {
						header('Location: '.$steamauth['loginpage']);
						exit;
					} else {
						?>
						<script type="text/javascript">
							window.location.href="<?=$steamauth['loginpage']?>";
						</script>
						<noscript>
							<meta http-equiv="refresh" content="0;url=<?=$steamauth['loginpage']?>" />
						</noscript>
						<?php
						exit;
					}
				} else {
					echo "User is not logged in.\n";
				}
			}
		} catch(ErrorException $e) {
			echo $e->getMessage();
		}

		return view('welcome_message');
	}

	//--------------------------------------------------------------------

}
