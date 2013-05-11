<?php

class Controller_Stream extends Controller_Template
{
  private $src     = '';
  private $query   = '';
  private $filter  = '';
  private $start_v = '';

  private $limit   = 20;

  public function action_index()
  {
    $limit = 20;
    $page  = $this->param('page');
    if(empty($page) || $page < 0 || !is_numeric($page)){
      $page   = 1;
    }
    $offset = $page -1;
    $query = 'SELECT * FROM animes ORDER BY unlikes, created_at DESC, likes DESC LIMIT '.($limit*$offset).', '.$limit;
    $list  = DB::query($query)->execute()->as_array();

    $soundcloud = false;
    $animes = array();
    foreach($list as $k => $anime){
      $video_info = array();
      if($this->cleanGet(Input::get('src')) === 'soundcloud'){
        $soundcloud = true;
        $video_info = $this->_getVideoFromSoundCloud($anime['title']);
      }else{
        $video_info = $this->_getVideoFromYouTube($anime['title']);
      }
      if(empty($video_info)){
        unset($list[$k]);
        continue;
      }
      // なるべくパーマリンク性を確保したいとおもっているのだけれど
      if(urlencode(Input::get('v')) == urlencode($video_info['hash'])){
        array_unshift($animes, array_merge($list[$k], $video_info));
      }else{
        $animes[] = array_merge($list[$k], $video_info);
      }
    }

    $isAllowAll = (Input::get('allow') == 'all') ? true : false;
    $v = Input::get('v');
    $this->template->content = View::forge('stream/index');
    $this->template->content->animes        = $this->_checkNew($animes);
    $this->template->content->page          = $page;
    $this->template->content->get_parameter = $this->generateGetParameter();
    $this->template->content->start_v_id    = Input::get('v');
    $this->template->content->q             = Input::get('q');
    $this->template->content->isAllowAll    = $isAllowAll;
    $this->template->content->isSoundCloud  = $soundcloud;
    $this->template->soundcloud             = $soundcloud;
  }

  /*
   * @return : アニメタイトルと、ビデオのハッシュを含んだ単純配列
   * アニメパーマなのか、ストリームなのかを判断してdispatchする
  **/
  private function _generateVideoList(){

  }

  /*
   * @return : ストリームなリストを返す
  **/
  private function _buildStreamList(){
    $anime_list = array();
    foreach($anime_list as $anime){
      // getVideoInfo()
    }
  }

  /*
   * @return : アニメパーマなリストを返す
  **/
  private function _buildAnimepermaList(){

  }

  /*
   * @retunr : リソースを判定してカウント分だけvideoInfosを返す
  **/
  private function _getVideoInfosFromResource()
  {

  }

  public function action_anime()
  {
    //***** ここは疑似コード *****

    // srcを確定する

    // queryを確定する

    // filterを確定する

    // startを取得する

    // リストを作る

    //****************************

    $limit = 20;
    $anime_id = $this->param('id');
    if(empty($anime_id) || $anime_id < 0 || !is_numeric($anime_id)){
      $query = 'SELECT * FROM animes ORDER BY id  DESC LIMIT 1';
    }else{
      $query = 'SELECT * FROM animes WHERE id=' . $anime_id;
    }
    $list  = DB::query($query)->execute()->as_array();

    $soundcloud = false;
    $animes = array();
    $anime = array_shift($list);
    if(Input::get('src') === 'soundcloud'){
      $soundcloud = true;
      $video_infos = $this->_getVideoFromSoundCloud($anime['title'], true);
    }else{
      $video_infos = $this->_getVideoFromYouTube($anime['title'], true);
    }
    foreach($video_infos as $video_info){
      // なるべくパーマリンク性を確保したいとおもっているのだけれど
      if(urlencode(Input::get('v')) == urlencode($video_info['hash'])){
        array_unshift($animes, array_merge($anime, $video_info));
      }else{
        $animes[] = array_merge($anime, $video_info);
      }
    }

    $isAllowAll = (Input::get('allow') == 'all') ? true : false;
    $this->template->content = View::forge('stream/index');
    $this->template->content->animes        = $this->_checkNew($animes);
    $this->template->content->get_parameter = $this->generateGetParameter();
    $this->template->content->start_v_id    = Input::get('v');
    $this->template->content->isSoundCloud  = $soundcloud;
    $this->template->content->isAllowAll    = $isAllowAll;
    $this->template->content->q             = Input::get('q');
    $this->template->soundcloud             = $soundcloud;
  }

  private function generateGetParameter()
  {
    $_params = array();
    $_q = $this->cleanGet(Input::get('q'));
    if(!empty($_q)){
      $_params['q'] = $_q;
    }
    switch(Input::get('src')){
      case  'soundcloud':
        $_params['src'] = $this->cleanGet(Input::get('src'));
        break;
      default:
        // do nothing
    }

    $parameter_string = '';
    $_i = 0;
    foreach($_params as $key => $val){
      if($_i===0){
        $parameter_string .= '?';
      }else{
        $parameter_string .= '&';
      }
      $parameter_string .= $key . '=' . $val;
      $_i = 1;
    }
    return $parameter_string;
  }

  private function _getVideoFromYouTube($anime_title, $is_anime_permalink=false)
  {
    $q = 'OP';
    $_q = Input::get('q');
    if(!empty($_q)){
      $q = $this->cleanGet($_q);
    }

    $url = 'http://gdata.youtube.com/feeds/api/videos';
    $url .= '?alt=json';
    if($is_anime_permalink){
      $url .= '&max-results='.'20';
    }else{
      $url .= '&max-results='.'6';
    }
    //$url .= '&orderby='.'rating';
    $url .= '&q='.urlencode($anime_title . ' ' . $q);
    $url .= '&category='.urlencode('Music');

    require_once 'HTTP/Request2.php';
    $req = new HTTP_Request2($url);
    $res = $req->send();

    $rows = json_decode($res->getBody(), true);

    if(empty($rows['feed']) || empty($rows['feed']['entry'])){
      return null;
    }

    if($is_anime_permalink){
      $video_lists = array();
      foreach($rows['feed']['entry'] as $info){
        if(empty($info['id'])){
          return null;
        }
        $elms  = explode('/',$info['id']['$t']);
        $vhash = array_pop($elms);

        $video = array();
        $video['vtitle'] = (isset($info['title']['$t'])) ? $info['title']['$t'] : '';
        $video['hash']   = $vhash;
        $video_lists[]   = $video;
      }
      return $video_lists;
    }

    // {{{ choose one
    $info = $this->_chooseAptYouTubeVideo($rows['feed']['entry']);

    if(empty($info['id'])){
      return null;
    }
    $elms  = explode('/',$info['id']['$t']);
    $vhash = array_pop($elms);

    $return = array();
    $return['vtitle'] = (isset($info['title']['$t'])) ? $info['title']['$t'] : '';
    $return['hash']   = $vhash;
    return $return;
    // }}}
  }

  private function _chooseAptYouTubeVideo($list)
  {
    foreach($list as $k => $info){

      if(
        Input::get('allow') != 'all' &&
        $this->_checkUTATTEMITA($info)
      ){
        continue;
      }

      $content_length = $info['media$group']['media$content'][0]['duration'];
      if(
        $content_length > 60*7
      ){
        continue;
      }

      return $info;
    }
  }

  private function _checkUTATTEMITA($info)
  {
    if(
      preg_match('/てみた/', $info['title']['$t'])
    ){
      return true;
    }
    return false;
  }

  private function _getVideoFromSoundCloud($anime_title, $is_anime_permalink=false)
  {
    $q = Input::get('q');
    $q = $this->cleanGet($q);

    $url = 'http://api.soundcloud.com/tracks.json?client_id=9ec24de791694f759c44ca0cf9f560de';
    if($is_anime_permalink){
      $url .= '&limit='.'20';
    }else{
      $url .= '&limit='.'6';
      //$url .= '&limit='.'1';
    }
    //$url .= '&genres='.'Anime';
    $url .= '&q='.urlencode($anime_title . ' ' . $q);

    require_once 'HTTP/Request2.php';
    $req = new HTTP_Request2($url);
    $res = $req->send();

    $rows = json_decode($res->getBody(), true);
    if(empty($rows)){
      return null;
    }

    if($is_anime_permalink){
      $video_lists = array();
      foreach($rows as $info){
        $video = array();
        $video['vtitle'] = (isset($info['title'])) ? $info['title'] : '';
        $video['hash']   = $info['permalink_url'];
        $video_lists[]   = $video;
      }
      return $video_lists;
    }

    // {{{ choose one
    $info = array_pop($rows); //$this->_chooseAptYouTubeVideo($rows['feed']['entry']);

    $return = array();
    $return['vtitle'] = (isset($info['title'])) ? $info['title'] : '';
    $return['hash']   = $info['permalink_url'];
    return $return;
    // }}}
  }

  // {{{
  function cleanGet($get)
  {
    // ?src=soundcloud?q=OP
    // ?q=OP?src=soundcloud
    // このケースを排除
    $elms = explode('?',$get);
    return array_shift($elms);
  }
  // }}}
}
