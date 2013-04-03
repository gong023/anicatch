<?php

class Controller_Api_Anime extends Controller_Rest
{
	public function action_index()
	{
    $hoge = array(
      'unko' => 2,
    );
    $this->response($hoge);
	}
}
