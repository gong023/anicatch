<?php

class Controller_Api_Anime extends Controller_Rest
{
	public function action_like()
	{
    $params = $this->params();
    $params['action'] = 'like';
    $res = array(
      'result' => "false",
      'params' => $params,
    );
    if($this->_isValidParams($params)){
      $res['result'] = "true";
    }
    $this->response(json_encode($res));
	}

	public function action_unlike()
	{
    $params = $this->params();
    $params['action'] = 'unlike';
    $res = array(
      'result' => "false",
      'params' => $params,
    );
    if($this->_isValidParams($params)){
      $res['result'] = "true";
    }
    $this->response(json_encode($res));
	}

  private function _isValidParams($params)
  {
    if(! is_numeric($params['id'])){
      return false;
    }
    return true;
  }
}
