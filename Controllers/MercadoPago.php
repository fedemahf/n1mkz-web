<?php namespace App\Controllers;

class Mercadopago extends BaseController
{
	public function index($segment = NULL)
	{
		switch($segment)
		{
			case 'notificacion':
				echo "<!-- index -->" . PHP_EOL;
				return $this->notificacion();
			break;

			case 'exito':
				$this->session->setFlashdata('success', 'El pago fue abonado con éxito.');
				return redirect()->to('/');
			break;

			case 'fallo':
				$this->session->setFlashdata('error', 'Hubo un problema al abonar el pago. Contacta con un administrador.');
				return redirect()->to('/');
			break;

			case 'pendiente':
				$this->session->setFlashdata('error', 'El pago quedó pendiente. El servicio será activado cuando finalices el pago.');
				return redirect()->to('/');
			break;
		}

		$this->session->setFlashdata('error', 'Solicitud desconocida.');
		return redirect()->to('/');

		// if($segment == 'notificacion')
		// {
		// 	echo "<!-- index -->" . PHP_EOL;
		// 	return $this->notificacion();
		// }

		// // Agrega credenciales
		// \MercadoPago\SDK::setAccessToken(getenv('MERCADOPAGO_TOKEN'));

		// // Crea un objeto de preferencia
		// $preference = new \MercadoPago\Preference();

		// // Crea un ítem en la preferencia
		// $item = new \MercadoPago\Item();
		// $item->title = 'Mi producto';
		// $item->quantity = 1;
		// $item->unit_price = 10.56;
		// $item->currency_id = "ARS";
		// $item->category_id = "games";
		// $preference->items = array($item);
		// $preference->back_urls = array(
		// 	"success" => base_url('mercadopago/exito'), // "https://www.tu-sitio/success",
		// 	"failure" => base_url('mercadopago/fallo'), // "http://www.tu-sitio/failure",
		// 	"pending" => base_url('mercadopago/pendiente') // "http://www.tu-sitio/pending"
		// );
		// $preference->notification_url = base_url('mercadopago/notificacion');
		// $preference->auto_return = "approved";
		// $preference->save();

		// echo PHP_EOL . "<!--" . PHP_EOL;

		// if(!empty($segment))
		// {
		// 	echo 'Segment:' . PHP_EOL;
		// 	var_dump($segment);
		// }

		// echo PHP_EOL . 'Method:' . PHP_EOL;
		// var_dump($this->request->getMethod());

		// echo PHP_EOL . 'Raw input:' . PHP_EOL;
		// var_dump($this->request->getRawInput());

		// echo PHP_EOL . 'collection_id' . PHP_EOL;
		// var_dump($this->request->getVar('collection_id')); // ID del pago de Mercado Pago.
		// echo 'collection_status' . PHP_EOL;
		// var_dump($this->request->getVar('collection_status')); // Estado del pago. Por ejemplo: approved para un pago aprobado o pending para un pago pendiente.
		// echo 'external_reference' . PHP_EOL;
		// var_dump($this->request->getVar('external_reference')); // Valor del campo external_reference que hayas enviado a la hora de crear la preferencia de pago.
		// echo 'payment_type' . PHP_EOL;
		// var_dump($this->request->getVar('payment_type')); // Tipo de pago. Por ejemplo: credit_card para tarjetas de crédito o ticket para medios de pago en efectivo.
		// echo 'merchant_order_id' . PHP_EOL;
		// var_dump($this->request->getVar('merchant_order_id')); // ID de la orden de pago generada en Mercado Pago.
		// echo 'preference_id' . PHP_EOL;
		// var_dump($this->request->getVar('preference_id')); // ID de la preferencia de pago de la que se está retornando.
		// echo 'site_id' . PHP_EOL;
		// var_dump($this->request->getVar('site_id')); // ID del país de la cuenta de Mercado Pago del vendedor. Por ejemplo: MLA para Argentina.
		// echo 'processing_mode' . PHP_EOL;
		// var_dump($this->request->getVar('processing_mode')); // Valor aggregator.
		// echo 'merchant_account_id' . PHP_EOL;
		// var_dump($this->request->getVar('merchant_account_id')); // Valor null.

		// echo PHP_EOL . 'preference_id: ' . $preference->id . PHP_EOL;

		// echo PHP_EOL . "-->" . PHP_EOL;

		// // var_dump(base_url('mercadopago/exito'));

		// $data['preference'] = $preference;
		// echo view('mercadopago', $data);
		// // return redirect()->to('/');
	}

	public function notificacion()
	{
		if(!empty($this->request->getVar('id')) && !empty($this->request->getVar('topic')))
		{
			$order_status = "";
			$paid_amount = 0;
			$total_amount = 0;

			if($this->request->getVar('topic') == 'merchant_order')
			{
				// Agrega credenciales
				\MercadoPago\SDK::setAccessToken(getenv('MERCADOPAGO_TOKEN'));

				$merchant_order = \MercadoPago\MerchantOrder::find_by_id($this->request->getVar('id'));
				$order_status = $merchant_order->order_status;
				$total_amount = $merchant_order->total_amount;
				$preference_id = $merchant_order->preference_id;

				// $paid_amount = 0;
				foreach ($merchant_order->payments as $payment) {
					if ($payment->status == 'approved'){
						$paid_amount += $payment->transaction_amount;
					}
				}

				// // If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
				// if ($paid_amount >= $total_amount) {
					// print_r("Totally paid. Release your item.");
				// } else {
					// print_r("Not paid yet. Do not release your item.");
				// }
			}

			// Guardar en la base de datos
			$this->db->table('mercadopago_notificacion')->insert(
				array(
					'notificacion_id' => $this->request->getVar('id'),
					'topic' => $this->request->getVar('topic'),
					'order_status' => $order_status,
					'paid_amount' => $paid_amount,
					'total_amount' => $total_amount,
					'preference_id' => $preference_id,
					'ip_address' => $_SERVER['REMOTE_ADDR']
				)
			);

			// Si completó el pago...
			if($order_status == 'paid' && $paid_amount >= $total_amount)
			{
				// Obtener usuario_id a partir del preference_id
				$row = $this->db
					->table('mercadopago_preference')
					->select('usuario_id, producto')
					// ->select('steam_id64')
					->where('preference_id', $preference_id)
					->where('abonado', 0)
					->get()
					->getRow();

				// Si se obtuvo el usuario_id...
				if(isset($row))
				{
					// Actualizar abonado
					$this->db
						->table('mercadopago_preference')
						->set('abonado', 1)
						->where('preference_id', $preference_id)
						->update();

					$this->activarVip($row->usuario_id, $row->producto);
				}
			}

			echo "ok";
		}
		else
		{
			echo "not ok";
		}

		// echo view('mercadopago');
	}
	
	public function regalar($usuario_id, $producto)
	{
		if($this->session->has('usuario_id') && $this->session->get('usuario_id') == 1)
		{
			$this->activarVip($usuario_id, $producto);
			$this->session->setFlashdata('success', "Regalaste el producto $producto a $usuario_id.");
		}

		return redirect()->to('/');
	}
	
	protected function activarVip($usuario_id, $producto)
	{
		// Obtener steam_id a partir del usuario_id
		$row = $this->db
			->table('usuario')
			->select('steam_id, nombre')
			// ->select('steam_id64')
			->where('id', $usuario_id)
			->get()
			->getRow();

		// Si se tuvo el steam_id...
		if(isset($row))
		{
			// Guardar steamID y steamID64
			$admin_id = 0;
			$nombre = $row->nombre;
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
			else
			{
				$db_sourcemod_local = $this->db_sourcemod_local;

				// No había admin_id, generarlo
				$db_sourcemod_local
					->table('sm_admins')
					->insert(
						array(
							'authtype' => 'steam',
							'identity' => $steamID,
							'flags' => 'a',
							'name' => $nombre,
							'immunity' => '5'
						)
					);

				// Guardar valor
				$admin_id = $db_sourcemod_local->insertID();
			}

			// Comprobar si tiene grupo establecido
			$row = $this->db_sourcemod_local
				->table('sm_admins_groups')
				->select('*')
				->where('admin_id', $admin_id)
				->where('group_id', 2)
				->get()
				->getRow();

			// Si no tiene grupo establecido...
			if(!isset($row))
			{
				// Establecer como VIP
				$this->db_sourcemod_local
					->table('sm_admins_groups')
					->insert(
						array(
							'admin_id' => $admin_id,
							'group_id' => 2,
							'inherit_order' => 2
						)
					);
			}

			// Básico, 31 días
			$diasVip = 31;

			switch($producto)
			{
				case 2:
					$diasVip *= 3; // 3 meses
				break;
				case 3:
					$diasVip *= 6; // 6 meses
				break;
			}

			// Margen de 1 día
			$diasVip += 1;

			// Comprobar si tenía VIP activo
			$row = $this->db
				->table('usuario_vip')
				->select('*')
				->where('usuario_id', $usuario_id)
				->get()
				->getRow();

			// Si tiene VIP activo...
			if(isset($row))
			{
				// Sumar 32 días
				$this->db
					->table('usuario_vip')
					->set('dias_restantes', 'dias_restantes+' . $diasVip, FALSE)
					->where('usuario_id', $usuario_id)
					->update();
			}
			else
			{
				// helper para función 'now()'
				helper('date');

				// No tenía VIP activo, guardarlo
				$this->db
					->table('usuario_vip')
					->insert(
						array(
							'usuario_id' => $usuario_id,
							'dias_restantes' => $diasVip
						)
					);

				// Comprobar si tenía armas modificadas
				$row = $this->db_sourcemod_local
					->table('weapons_disabled')
					->select('*')
					->where('steamid', $steamID)
					->get()
					->getRow();
	
				// Si tenía armas modificadas...
				if(isset($row))
				{
					// Eliminar posibles valores activos en db
					$this->db_sourcemod_local->table('weapons')->delete(['steamid' => $steamID]);
					$this->db_sourcemod_local->table('weapons_timestamps')->delete(['steamid' => $steamID]);
					
					// Activar los valores antiguos
					$this->db_sourcemod_local->query("INSERT INTO `weapons` SELECT * FROM `weapons_disabled` WHERE `steamid`='$steamID'");
					$this->db_sourcemod_local
						->table('weapons_timestamps')
						->insert(
							array(
								'steamid' => $steamID,
								'last_seen' => now()
							)
						);
				}
			}
		}
	}

	public function comprar($producto = NULL)
	{
		if(empty($producto))
		{
			$this->session->setFlashdata('error', 'No se ha indicado un producto.');
			return redirect()->to('/');
		}
		else
		{
			$precio = 0;
			$nombre = "";
			settype($producto, "integer");

			switch($producto)
			{
				case 1:
					$nombre = "VIP 1 n1mkz.net";
					$precio = 100;
				break;

				case 2:
					$nombre = "VIP 3 n1mkz.net";
					$precio = 275;
				break;

				case 3:
					$nombre = "VIP 6 n1mkz.net";
					$precio = 500;
				break;
			}

			if($precio == 0)
			{
				$this->session->setFlashdata('error', 'El producto es desconocido.');
				return redirect()->to('/');
			}
			else
			{
				if(!$this->session->has('steam_id'))
				{
					$this->session->setFlashdata('error', 'Debés iniciar sesión.');
					return redirect()->to('/');
				}
				else
				{
					// Agrega credenciales
					\MercadoPago\SDK::setAccessToken(getenv('MERCADOPAGO_TOKEN'));

					// Crea un objeto de preferencia
					$preference = new \MercadoPago\Preference();

					// Crea un ítem en la preferencia
					$item = new \MercadoPago\Item();
					$item->title = $nombre;
					$item->quantity = 1;
					$item->unit_price = $precio;
					$item->currency_id = "ARS";
					$item->category_id = "games";
					$preference->items = array($item);
					$preference->back_urls = array(
						"success" => base_url('mercadopago/exito'), // "https://www.tu-sitio/success",
						"failure" => base_url('mercadopago/fallo'), // "http://www.tu-sitio/failure",
						"pending" => base_url('mercadopago/pendiente') // "http://www.tu-sitio/pending"
					);
					$preference->notification_url = base_url('mercadopago/notificacion');
					$preference->auto_return = "approved";
					// $preference->binary_mode = true;
					$preference->save();

					// Guardar en la base de datos
					$this->db->table('mercadopago_preference')->insert(
						array(
							'usuario_id' => $this->session->get('usuario_id'),
							// 'steam_id64' => $this->session->get('steam_id'),
							'preference_id' => $preference->id,
							'producto' => $producto,
							'ip_address' => $_SERVER['REMOTE_ADDR']
						)
					);

					return redirect()->to($preference->init_point);
				}
			}
		}
	}

	public function check($topic = NULL, $id = NULL)
	{
		if(empty($topic) || empty($id))
		{
			return redirect()->to('/');
		}
		else
		{
			// Agrega credenciales
			\MercadoPago\SDK::setAccessToken(getenv('MERCADOPAGO_TOKEN'));

			$merchant_order = null;

			switch($topic) {
				case "payment":
					$payment = \MercadoPago\Payment::find_by_id($id);

					var_dump($payment);
					echo PHP_EOL;

					// Get the payment and the corresponding merchant_order reported by the IPN.
					$merchant_order = \MercadoPago\MerchantOrder::find_by_id($payment->order->id);
					break;
				case "merchant_order":
					$merchant_order = \MercadoPago\MerchantOrder::find_by_id($id);
					break;
			}

			var_dump($merchant_order);

			$paid_amount = 0;
			foreach ($merchant_order->payments as $payment) {
				if ($payment->status == 'approved'){
					$paid_amount += $payment->transaction_amount;
				}
			}

			// If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
			if($paid_amount >= $merchant_order->total_amount){
				// if (count($merchant_order->shipments)>0) { // The merchant_order has shipments
				// if (!empty($merchant_order->shipments)) { // The merchant_order has shipments
					// if($merchant_order->shipments->status == "ready_to_ship") {
						// print_r("Totally paid. Print the label and release your item.");
					// }
				// } else { // The merchant_order don't has any shipments
					print_r("Totally paid. Release your item.");
				// }
			} else {
				print_r("Not paid yet. Do not release your item.");
			}
		}
	}
}
