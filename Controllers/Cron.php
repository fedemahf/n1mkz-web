<?php namespace App\Controllers;

class Cron extends BaseController
{
	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		if(!is_cli())
		{
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function index()
	{
		$mercadopagoController = new \App\Controllers\MercadoPago();
		$mercadopagoController->desactivarVip(16);
		echo "ok" . PHP_EOL;
	}
}
