/**
 * top
**/

function init(){
  registEffectiveBtns();
}

function registEffectiveBtns(){
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
