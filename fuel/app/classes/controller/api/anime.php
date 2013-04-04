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
      $anime = $this->getAnimeById($params['id']);
      $likes = $anime['likes'] + 1;
      if($this->updateAnimeLikesUnlikesById($params['id'], array('likes'=>$likes))){
        $res['result'] = true;
      }
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
      $anime = $this->getAnimeById($params['id']);
      $unlikes = $anime['unlikes'] + 1;
      if($this->updateAnimeLikesUnlikesById($params['id'], array('unlikes'=>$unlikes))){
        $res['result'] = true;
      }
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

  private function getAnimeById($id)
  {
    $query  = 'SELECT * FROM animes WHERE id=' . $id . ' LIMIT 1';
    $animes = DB::query($query)->execute()->as_array();
    if(count($animes) === 1){
      return array_shift($animes); 
    }
    return null;
  }

  private function updateAnimeLikesUnlikesById($id, $params)
  {
      if(isset($params['likes'])){
        $query   = 'UPDATE animes SET likes='   . $params['likes']   .' WHERE id='.$id;
        $success = DB::query($query)->execute();
      }else if(isset($params['unlikes'])){
        $query   = 'UPDATE animes SET unlikes=' . $params['unlikes'] .' WHERE id='.$id;
        $success = DB::query($query)->execute();
      }
      if($success){
        return true;
      }
      return false;
  } 
}
