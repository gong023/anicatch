/**
 * ajax method
**/
var xhr = {};
var API_HOST_URL  = 'http://api.anicatch.net';
var CONFIRM_UNLIKE_SERIF = "これ押しちゃうとこのアニメがリストに戻ってくるのはけっこう絶望的ですが、マジすか？";
var CONFIRM_REJECT_SERIF = "マッチしてない動画を排除できます。消してもよい？";

var ajax = {
  call : function(func, param, callback){
    var method  = 'POST';
    var url     = API_HOST_URL;
    var async   = true;
    var data    = {};
    switch(func){
      case 'likeAnime':
        url += ('/anime/' + param + '/like');
        break;
      case 'unlikeAnime':
        url += ('/anime/' + param + '/unlike');
        break;
      case 'rejectVideo':
        url += ('/anime/' + param.anime_id + '/reject/' + param.vhash + '/src/' + param.src);
        break;
      default:
        console.log('Undefined ajax func call');
        callback(false);
    }
    xhr = new XMLHttpRequest();
    xhr.open(method, url, async, data);
    //xhr.setRequestHeader('Pragma', 'no-cache');
    //xhr.setRequestHeader('Cache-Control', 'no-cache');
    //xhr.setRequestHeader('If-Modified-Since', 'Thu, 01 Jun 1970 00:00:00 GMT');
    //xhr.responseType = 'json';
    xhr.onreadystatechange = function(){
      onRequestStateChange(callback);
    };
    xhr.send(data);
  },
};

function onRequestStateChange(cb){
  if(
    xhr.readyState === 4    &&
    xhr.status     === 200  &&
    xhr.responseText != void 0
  ){
    var domparser = new DOMParser();
    domparser.async = false;
    var xml = domparser.parseFromString(xhr.responseText, "application/xml");
    var jsonstring = xml.getElementsByTagName('item')[0].textContent;
    cb(JSON.parse(jsonstring));
  }
}

function registAjaxBtns(){
  var likeAnimeBtn = document.getElementById('like-anime');
  likeAnimeBtn.addEventListener('click',function(){
    var self = this;
    ajax.call('likeAnime', __playlist[__index]['animeid'], function(res){
      console.log('Ajax is back -> ', res);
      if(res.result){
        ageAction(function(){
          //replaceInnerHTML(self, '<h1>(☝ ՞ω ՞)☝</h1>');
          replaceInnerHTML(self, '<div></div>');
        });
      }
    });
  });
  var unlikeAnimeBtn = document.getElementById('unlike-anime');
  if(unlikeAnimeBtn){
    unlikeAnimeBtn.addEventListener('click',function(){
      if(window.confirm(CONFIRM_UNLIKE_SERIF)){
        var self = this;
        ajax.call('unlikeAnime', __playlist[__index]['animeid'], function(res){
          console.log('Ajax is back -> ', res);
          if(res.result){
            sageAction(function(){
              //replaceInnerHTML(self, '<h1>(´・ω・`)</h1>', { color : '#aaa'});
              replaceInnerHTML(self, '<div></div>');
            });
          }else{
            alert('ちょっと失敗した');
          }
        });
      }
    });
  }
  var videoWrong = document.getElementById('video-wrong');
  videoWrong.addEventListener('click',function(){
    if(window.confirm(CONFIRM_REJECT_SERIF)){
      var self = this;
      var param = {
        anime_id : __playlist[__index]['animeid'],
        vhash    : __playlist[__index]['hash'],
      };
      param.src = 1;//youtube
      if(window.location.search.match(/soundcloud/)){
        param.src = 2;//soundcloud
      }
      ajax.call('rejectVideo', param, function(res){
        console.log('Ajax is back -> ', res);
        if(res.result){
          rejectAction(function(){
            replaceInnerHTML(self, '<div></div>');
          });
        }else{
          console.log('ちょっと失敗した(☝◞‸◟)☝');
        }
      });
    }
  });
}

function replaceInnerHTML(trgt, html, styles){
  trgt.removeEventListener('click');
  trgt.setAttribute('class',''); 
  trgt.innerHTML = html;
  trgt.style.textDecoration = 'none';
  if(styles && styles.color != void 0){
    trgt.style.color = styles.color;
  }
}
