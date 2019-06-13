//**************************************************
//  Trial Version
//
//
//  Deluxe Tree (c) 2006 - 2007, by Deluxe-Tree.com
//  version 2.4
//  http://deluxe-tree.com
//
//  ------
//  Obfuscated by Javascript Obfuscator
//  http://javascript-source.com

//
//**************************************************

function _tsc(){return[(tim?tde.scrollLeft:pageXOffset),(tim?tde.scrollTop:pageYOffset)]}function _tgc(trt,tc,tn1){var txd=(tn1-tc)/trt;with(Math)if(abs(txd)<1)txd=abs(txd)/txd;return tc+((tc!=tn1)?txd:0)+'px';}function _tsw(){if(tmoveRec.tmo)return;for(var tj=0;tj<tt.ln();tj++)with(tt[tj]){if(tff&&tap){var tom=_toi(id+'div');var tyx=_tsx(tom);var tfo=_tsc();var x=tfo[0]+parseInt(left);var y=tfo[1]+parseInt(top);if(tfloatableX&&tyx[0]!=x)tom.style.left=_tgc(tfloatIterations,tyx[0],x);if(tfloatableX&&tyx[1]!=y)tom.style.top=_tgc(tfloatIterations,tyx[1],y);}}}var tum=null;function _tse(){return(tmoveRec.tmo?false:true)}function _tee(te){if(tam&&tie)te=window.event;with(te)return[(tie||tpo)?clientX:pageX,(tie||tpo)?clientY:pageY];}function _tm(){if(dtdo.attachEvent){dtdo.attachEvent('onmousemove',_tm2);if(tie)dtdo.attachEvent("onselectstart",_tse);}else{tum=dtdo.onmousemove;dtdo.onmousemove=function(te){_tm2(te);if(tum)tum();return true;}}}function _tl1s(tvn,tmi){with(tmoveRec){if(!tl1||tmo)return;_tmv=tt[tmi];tom=_toi(_tmv.id+'div');var tms=_tee(tvn);var tyx=_tsx(tom);var tpo1=tim?_tsc():[0,0];ttx=tms[0]-tyx[0]+tpo1[0];tty=tms[1]-tyx[1]+tpo1[1];tmo=1;}}function _tm2(event){with(tmoveRec)if(tmo&&tl1){var tms=_tee(event);var tpo1=tim?_tsc():[0,0];var txn=tms[0]-ttx+tpo1[0];var tyn=tms[1]-tty+tpo1[1];with(tom.style){left=((txn>=0)?txn:0)+'px';top=((tyn>=0)?tyn:0)+'px';}}return true;}function _tl11(){with(tmoveRec){if(!tl1||!tmo)return;var tpo1=_tsc();var tyx=_tsx(tom);_tmv.left=tyx[0]-tpo1[0];_tmv.top=tyx[1]-tpo1[1];tmo=0;}}
