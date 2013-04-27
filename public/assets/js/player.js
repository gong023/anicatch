/**
 * main.jsにリネームするかも
**/
var __playlist = [];
var __index    =  0;
var __player   = {};

var btnHTML =  '<a tabindex="1" id="like-anime"   anime-id="" class="btn btn-large btn-primary">好き</a><a tabindex="1" id="unlike-anime" anime-id="" class="btn btn-large btn-inverse">これ今期アニメじゃない</a>';
var defPauseBtnClass =    "btn btn-large switch-pause btn-inverse",
    pauseBtnChangeClass = "btn-inverse";

// see : https://developers.google.com/youtube/js_api_reference?hl=ja#Events
var STATE = {
  READY    : -1,
  ENDED    :  0,
  PLAYING  :  1,
  STOPED   :  2,
  BUFFERING:  3,
  HEADED   :  5,
}

function init(){
  initPlaylist(__playlist);
  initPlayer(__playlist[__index]['hash']);
  displayInfo();
  registControleBtns();
  registReplaceBtns();
  registAjaxBtns();
}

function registControleBtns(){

  var prevBtns = document.getElementsByClassName('play-prev');
  for(var i=0; i<prevBtns.length; i++){
    prevBtns[i].addEventListener('click', playPrev);
  }
  var nextBtns = document.getElementsByClassName('play-next');
  for(var i=0; i<nextBtns.length; i++){
    nextBtns[i].addEventListener("click", playNext);
  }

  var directBtns = document.getElementsByClassName('play-direct');
  for(var i=0; i<directBtns.length; i++){
    directBtns[i].addEventListener("click", function(){
      var seq = this.getAttribute('seq');
      playDirect(seq);
    });
  }

  var pauseBtn = document.getElementById('cont-pause');
  pauseBtn.addEventListener('click', function(){
    togglePauseBtnValue();
    switchPause();
  });
}

function initPlaylist(__playlist, is_sub){
  var class_name = 'anime';
  if(is_sub){
    class_name = 'subanime';
  }
  var animes = document.getElementsByClassName(class_name);
  for(var i=0; i<animes.length; i++){
    var video = {
      "seq"     : animes[i].getAttribute('seq'),
      "animeid" : animes[i].getAttribute('anime-id'),
      "hash"    : animes[i].getAttribute('hash'),
      "atitle"  : animes[i].getAttribute('atitle'),
      "aurl"    : animes[i].getAttribute('aurl'),
      "vtitle"  : animes[i].innerHTML,
    };
    __playlist.push(video);
  }
}

function initPlayer(initialID){
  var params = { allowScriptAccess: "always" };
  var atts   = { id: "player" };
  swfobject.embedSWF(
    "http://www.youtube.com/v/" + initialID + "?enablejsapi=1&playerapiid=ytplayer", 
    "video",
    "460",
    "360",
    "8",
    null,
    null,
    params,
    atts
  );
}

// pre-registered method
function onYouTubePlayerReady(){
  __player = document.getElementById('player');
  __player.addEventListener("onStateChange", "stateDispatcher");
  __player.addEventListener("onError",       "errorHandler");
}

function stateDispatcher(state){
  //console.log(state);
  switch(state){
    case STATE.READY:
      break;
    case STATE.ENDED:
      playNext();
      break;
    case STATE.PLAYING:
      togglePauseBtnValue(STATE.PLAYING);
      break;
    case STATE.STOPED:
      break;
    case STATE.BUFFERING:
      break;
    case STATE.HEADED:
      break;
    default:
      // do nothing
  }
}

function errorHandler(){
  setTimeout(function(){
    playNext();
  },800);
}

function displayInfo(){
  var atitle = document.getElementById('anime-title');
  atitle.innerHTML = __playlist[__index]['atitle'];

  var vtitle = document.getElementById('video-title');
  var innerVal = __playlist[__index]['vtitle'];
  vtitle.innerHTML = __playlist[__index]['vtitle'];

  var str = 'http://www.youtube.com/watch?v=' + __playlist[__index]['hash'];
  var vurl = document.getElementById('video-url');
  vurl.innerHTML = str;
  vurl.setAttribute('href', str);
  vurl.addEventListener('click', function(){
    pause();
  });

  var str = __playlist[__index]['aurl'];
  var aurl = document.getElementById('anime-url');
  aurl.innerHTML = str;
  aurl.setAttribute('href', str);

  // initialize tr
  var trs = document.getElementsByClassName('animetr');
  for(var i=0; i<trs.length; i++){
    trs[i].setAttribute('class', 'animetr');
  }
  var tr = document.getElementById('index_' + String(__index));
  tr.setAttribute('class', 'animetr nowplaying');

  // change title
  var title = document.getElementsByTagName('title');
  title[0].innerHTML = __playlist[__index]['atitle'] + ' - あにきゃっち.net';

  var face = document.getElementById('atitle-reject');
  face.innerHTML = __playlist[__index]['atitle'];
}

function enableEvaluateBtns(){

}

function playNext(){
  var is_last = false;
  if(__index > (__playlist.length - 1)){
    is_last = true;
  }
  if(is_last){
    __index = 0;
  }else{
    __index = __index + 1;
  }
  _playThis();
}

function playPrev(){
  var is_first = false;
  if(__index < 1){
    is_first = true;
  }
  if(is_first){
    __index = (__playlist.length - 1);
  }else{
    __index = __index - 1;
  }
  _playThis();
}

function playDirect(seq){
  __index = parseInt(seq);
  _playThis();  
}

function toggleHide(){
  var btn = document.getElementById('cont-hide');
  switch(btn.getAttribute('state')){
    case "1":
      __player.style.position = "fixed";
      __player.style.top = "-500px";
      btn.innerHTML = "show";
      btn.setAttribute('state', '0');
      break;
    case "0":
    default:
      __player.style.position = "";
      __player.style.top = "";
      btn.innerHTML = "hide";
      btn.setAttribute('state', '1');
  }
}

function togglePauseBtnValue(state){
  var btn = document.getElementById('cont-pause');
  if(state == STATE.PLAYING){
    btn.setAttribute('state', '0');
  }
  switch(btn.getAttribute('state')){
    case "0":
      btn.setAttribute('state', '1');
      btn.innerHTML = 'PAUSE';
      removeClass(btn, pauseBtnChangeClass);
      break;
    case "1":
    default:
      btn.setAttribute('state', '0');
      btn.setAttribute('class', defPauseBtnClass);
      btn.innerHTML = 'PLAY';
  }
}

function switchPause(){
  switch(__player.getPlayerState()){
    case STATE.STOPED:
    case STATE.READY:
      play();
      break;
    case STATE.PLAYING:
    default:
      pause();
      break;
  }
}

function pause(){
  __player.pauseVideo();
}
function play(){
  __player.playVideo();
}

function _playThis(){
  __player.loadVideoById(__playlist[__index]['hash']);
  displayInfo();
}

function removeClass(el, c) {
  var triml = /^\s+/,
      trimr = /\s+$/;
  el.className = (' ' + el.className + ' ').replace(' ' + c + ' ', '').replace(triml, '').replace(trimr, '');
}
