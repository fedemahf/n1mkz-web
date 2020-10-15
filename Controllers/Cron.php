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

		if($_SERVER['REMOTE_ADDR'] != '45.235.99.146')
		{
			// return redirect()->to('/');
			echo $_SERVER['REMOTE_ADDR'] . PHP_EOL;
			// throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}

	public function index()
	{
		echo "ok";
	}
}
