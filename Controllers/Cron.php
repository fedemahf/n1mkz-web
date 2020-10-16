<?php namespace App\Controllers;

use \App\Controllers\Vip;

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
		// $vipController = new \App\Controllers\Vip();
		$this->desactivarVip(16);
		echo "ok" . PHP_EOL;
	}
}
