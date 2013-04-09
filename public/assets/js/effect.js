function registReplaceBtns(){
  var replaceBtns = document.getElementsByClassName('replace-loader');
  for(var i=0; i<replaceBtns.length; i++){
    replaceBtns[i].addEventListener('click', function(){
      replaceLoader(this);
    });
  }
}

function replaceLoader(dom){
  dom.className = (' ' + dom.className + ' ')
    .replace(' btn ','')
    .replace(' btn-primary ','')
    .replace(' btn-large ','');
  dom.innerHTML = '<div class="loader middle"></div>Now Loading...';
}

function ageAction(callback){
  var dom = document.getElementById('age-face-hidden');
  _SlideAnimation(dom, { top : '1000px' }, { top : '-1000px' }, 300, callback);
}

function sageAction(callback){
  var dom = document.getElementById('sage-face-hidden');
  _SlideAnimation(dom, { bottom : '1500px' }, { bottom : '-500px' }, 300, callback);
}

function rejectAction(callback){
  var dom = document.getElementById('reject-face-hidden');
  _FlowAnimation(dom, '2000px', '-1000px', 400, callback);
}

function _SlideAnimation(dom, start, dest, duration, cb){
  cb(); // do not wait this action
  var distPerIteration = 0;
  var cnt = 0;
  if(dest.bottom != void 0){
    distPerIteration = Math.floor(Math.abs(_extrPX(dest.bottom) - _extrPX(start.bottom)) / duration);
    dom.style.bottom = start.bottom;
  }else{
    distPerIteration = Math.floor(Math.abs(_extrPX(dest.top) - _extrPX(start.top)) / duration);
    dom.style.top    = start.top;
  }
  var animation = setInterval(function(){
    // TODO: do not use counter
    cnt++;
    if(cnt > 300){
      clearInterval(animation);
    }
    if(dest.bottom != void 0){
      if(dom.style.bottom == dest.bottom){
        // finish condition
        clearInterval(animation);
        dom.style.bottom = start.bottom + 'px';
        cb();
      }else{
        // is not finish
        dom.style.bottom = (_extrPX(dom.style.bottom) - distPerIteration) + 'px';
      }
    }else{
      if(dom.style.top == dest.top){
        // finish condition
        clearInterval(animation);
        dom.style.top = start.top + 'px';
        cb();
      }else{
        // is not finish
        dom.style.top = (_extrPX(dom.style.top) - distPerIteration) + 'px';
      }
    }
  },1);
}

function _FlowAnimation(dom, startleft, destleft, duration, cb){
  cb(); // do not wait this action
  var distPerIteration = 0;
  var cnt = 0;
  distPerIteration = Math.floor(Math.abs(_extrPX(destleft) - _extrPX(startleft)) / duration);
  dom.style.left    = startleft;
  var animation = setInterval(function(){
    // TODO: do not use counter
    cnt++;
    if(cnt > 3000){
      clearInterval(animation);
    }
    if(dom.style.left == destleft){
      // finish condition
      clearInterval(animation);
      dom.style.left = startleft + 'px';
      cb();
    }else{
      // is not finish
      dom.style.left = (_extrPX(dom.style.left) - distPerIteration) + 'px';
    }
  },1);
}
function _extrPX(pixelString){
  return parseInt(pixelString.replace('px',''));
}

