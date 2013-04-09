<?php

class Controller_Api_Anime extends Controller_Rest
{
  protected $mess;

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

  public function action_reject()
  {
    $params = $this->params();
    $params['action'] = 'reject';
    $res = array(
      'result' => "false",
      'params' => $params,
    );
    if($this->_isValidParams($params) && isset($params['vhash'])){
      if($this->rejectVideoOfAnime($params['id'], $params['vhash'])){
        $res['result'] = true;
        if(isset($this->mess)){
          $res['message'] = $this->mess;
        }
      }
    }
    $this->response(json_encode($res));
  }

  private function _isValidParams($params)
  {
    if(! is_numeric($params['id'])){
      return false;
    }
    if(isset($params['vhash'])){
      if(!preg_match('/[a-zA-Z0-9_]{11}/', $params['vhash'])){
        return false;
      }
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
    $success = false;
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

  private function rejectVideoOfAnime($id, $params)
  {
    $success = false;
    if(isset($params['vhash'])){
      $query = "INSERT IGNORE INTO rejected_videos (anime_id, hash, created_at) VALUES ('{$id}', '{$params['vhash']}', NOW())";
      try {
        $success = DB::query($query)->execute();
      } catch (Exception $e) {
        $this->mess = $e->getMessage();
      }
      $success = true;
    }
    if($success){
      return true;
    }
    return false;
  }
}
