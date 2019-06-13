function setCookie(name, value, expires, path, domain, secure)
 {
   document.cookie = name + "=" + escape(value) +
   ((expires == null) ? "" : "; expires=" + expires.toGMTString()) +
   ((path == null) ? "" : "; path=" + path) +
   ((domain == null) ? "" : "; domain=" + domain) +
   ((secure == null) ? "" : "; secure");
 }

var expiration = new Date();
expiration.setTime(expiration.getTime() + 24 * 60 * 60 * 60 * 1000 * 3);
function set_cookie(){
setCookie('admin_cookie',document.formis.usuario.value,  expiration);
}

function getCookie(name){
  var cname = name + "=";
  var dc = document.cookie;
  if (dc.length > 0) {
    begin = dc.indexOf(cname);
    if (begin != -1) {
     begin += cname.length;
     end = dc.indexOf(";", begin);
     if (end == -1) end = dc.length;
     return unescape(dc.substring(begin, end));
     }}

}

function cargar_cookie ()
{
if(getCookie('admin_cookie')){
  document.formis.usuario.value=getCookie('admin_cookie')
  document.formis.clave.focus();
}
else
    document.formis.usuario.focus();
}

