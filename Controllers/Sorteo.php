<?php namespace App\Controllers;

class Sorteo extends BaseController
{
	public function objetivo_twitter()
	{
		if($this->session->has('steam_id'))
		{
			$this->db
				->table('usuario_sorteo')
				->set('twitter', 1)
				->where('usuario_id', $this->session->get('usuario_id'))
				->update();
		}

		return redirect()->to('/');
	}

	public function objetivo_youtube()
	{
		if($this->session->has('steam_id'))
		{
			$this->db
				->table('usuario_sorteo')
				->set('youtube', 1)
				->where('usuario_id', $this->session->get('usuario_id'))
				->update();
		}

		return redirect()->to('/');
	}
}
