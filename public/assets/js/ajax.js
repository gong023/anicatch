/**
 * ajax method
**/
var xhr = {};
var API_HOST_URL = 'http://api.anicatch.net';

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
    ajax.call('likeAnime', this.getAttribute('anime-id'), function(res){
      console.log('Ajax is back -> ', res);
      if(Boolean(res.result)){
        ageAction(function(){
          //replaceInnerHTML(self, '<h1>(☝ ՞ω ՞)☝</h1>');
          replaceInnerHTML(self, '<div></div>');
        });
      }
    });
  });
  var unlikeAnimeBtn = document.getElementById('unlike-anime');
  unlikeAnimeBtn.addEventListener('click',function(){
    var self = this;
    ajax.call('unlikeAnime', this.getAttribute('anime-id'), function(res){
      console.log('Ajax is back -> ', res);
      if(Boolean(res.result)){
        sageAction(function(){
          //replaceInnerHTML(self, '<h1>(´・ω・`)</h1>', { color : '#aaa'});
          replaceInnerHTML(self, '<div></div>');
        });
      }
    });
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
