<?php namespace App\Controllers;

class Cron extends BaseController
{
	/**
	 * Constructor.
	 */
	// public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	// {
	// 	// Do Not Edit This Line
	// 	parent::initController($request, $response, $logger);

	// 	// if(!is_cli())
	// 	// {
	// 	// 	throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	// 	// }
	// }

	public function index()
	{
		// $vipController = new \App\Controllers\Vip($this->db, $this->db_sourcemod_local);
		// $vipController->desactivarVip(16);
		// echo "ok" . PHP_EOL;

		
		$query =
			$this->db
				->table('usuario_vip')
				// ->select('(UNIX_TIMESTAMP(`fecha_final`) - UNIX_TIMESTAMP(NOW())) as `segundos_restantes`', FALSE)
				->where('(UNIX_TIMESTAMP(`fecha_final`) - UNIX_TIMESTAMP(NOW())) >', "0", false)
			// ->get();
			->getCompiledSelect();
		
		echo $query . PHP_EOL;

	}
}
