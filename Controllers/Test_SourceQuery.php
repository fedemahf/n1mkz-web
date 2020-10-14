<?php namespace App\Controllers;

use xPaw\SourceQuery\SourceQuery;

class Test_SourceQuery extends BaseController
{
	public function index()
	{
		// echo "Test_SourceQuery::index init<br>";

		for ($i = 27016; $i <= 27020; $i++)
		{
			$query = new SourceQuery();

			try
			{
				$query->Connect('45.235.99.146', $i, 1, SourceQuery::SOURCE);
				$data['sourceQuery'][] = $query->GetInfo();
			}
			catch(Exception $e)
			{
				log_message('error', '[Test_SourceQuery] ' . $e->getMessage());
			}
			finally
			{
				$query->Disconnect();
			}
		}
		
		// var_dump($data);
		
		// echo "Test_SourceQuery::index end<br>";

		echo view('portada', $data);
		// return redirect()->to('/');
	}
}
