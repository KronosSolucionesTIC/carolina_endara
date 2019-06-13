var tWorkPath="menus/data.files/";
function MM_jumpMenu(targ,selObj,restore){ //v3.0
	 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function cambio(op) {
	if(op==1) {	
		document.getElementById('act_pag').value=1   ;	
	}
	if(op==2) {
		if(document.getElementById('act_pag').value >1  ) {
			document.getElementById('act_pag').value=parseInt(document.getElementById('act_pag').value) - 1;
		}
	}
	if(op==3) {
		if( parseInt(document.getElementById('cant_pag').value)  > parseInt(document.getElementById('act_pag').value)  ) {	
			document.getElementById('act_pag').value=parseInt(document.getElementById('act_pag').value) + 1;
		}
	}
	if(op==4) {	
		document.getElementById('act_pag').value=document.getElementById('cant_pag').value   ;
	}
	document.forma.submit();
	}

function buscar()
	{
		//alert(document.getElementById('texto').value)
		//return false;
		if(document.getElementById('campos').value == -1)
		{
			document.getElementById('busquedas').value="";
			document.getElementById('cant_pag').value =1;
			document.getElementById('act_pag').value =1;
			document.forma.submit();
		}
		else 
		{
			if(document.getElementById('texto').value=="" || document.getElementById('campos').value==0)
			{
				alert("Complete los Parametros, Gracias")
				return false;
			}
	
			else
			{
				document.getElementById('busquedas').value= document.getElementById('campos').value + "|" + document.getElementById('texto').value ;
				document.getElementById('cant_pag').value =1;
				document.getElementById('act_pag').value =1;
				document.forma.submit();
			}
		}
	}

function cambio_1(cant_pag,act_pag) {  //para el manejo de loas imagenes de paginacion

	var pag=cant_pag ;
var aux=0;
	if(cant_pag <= 1) {	
		document.getElementById('ultimo').style.display="none";
		document.getElementById('siguiente').style.display="none";
		document.getElementById('primero').style.display="none";
		document.getElementById('regresar').style.display="none";
		aux=1;
	}
	if(act_pag == 1  &  aux==0) {	
		document.getElementById('ultimo').style.display="inline";
		document.getElementById('siguiente').style.display="inline";
		document.getElementById('primero').style.display="none";
		document.getElementById('regresar').style.display="none";
		aux=1;
	}
	if(act_pag >1 && cant_pag> act_pag &  aux==0) {	
		document.getElementById('ultimo').style.display="inline";
		document.getElementById('siguiente').style.display="inline";
		document.getElementById('primero').style.display="inline";
		document.getElementById('regresar').style.display="inline";
		aux=1;
	}
	if(cant_pag >= act_pag  &  aux==0) {	
		document.getElementById('ultimo').style.display="none";
		document.getElementById('siguiente').style.display="none";
		document.getElementById('primero').style.display="inline";
		document.getElementById('regresar').style.display="inline";
		aux=1;
	}
}

function cambio_guardar() {	
	var mensaje=datos_completos();
	if (mensaje==true) {
		document.getElementById('guardar').value=1;
		document.forma.submit();
	}
	else
		alert('Complete el Formulario, Gracias')
	}

function validaInt(){
	if (event.keyCode>47 & event.keyCode<58) {
		return true;
		}
	else{
		return false;
		}
}

function validaInt_evento(a,obj){
	var vandera=0;
	if(event.keyCode ==13 && vandera==0 ) {
		document.getElementById(obj).focus();
	}
	else {
		if (event.keyCode>47 & event.keyCode<58) {
			return true;
		}
		else{
			return false;
		}
	}
}


function valida_evento(a,obj){
	var vandera=0;
	if(event.keyCode ==13 && vandera==0 ) {
		document.getElementById(obj).focus();
	}
}




function confirmar(codigo)
	{
		if(confirm("¿Esta seguro de Eliminar el Registro?.")) 
		{
			document.getElementById('eliminacion').value=1;
			document.getElementById('eli_codigo').value=codigo;
			document.forma.submit();		
		} 
	} 
	
	
function validaFloat(obj){

if (event.keyCode==46 && obj.value=="")
	obj.value="0";

if (event.keyCode==46 && obj.value!="")
{
	if(obj.value.indexOf(".")>-1)
	return false;
}



if (event.keyCode > 47 & event.keyCode < 58){
	var cero = parseInt(obj.value.substring(0,1));
	var segundo = obj.value.substring(1,2);
	if( cero == 0 & segundo != ".") return false;
}


if (event.keyCode>47 & event.keyCode<58 || event.keyCode==46)
	return true;
else
	return false;
}


function validaValue(obj){
	var arreglo = obj.value.split(".");
	if(obj.value.substring(0,1) == ".")  
	
		obj.value = "0" + obj.value;
	if(parseInt(arreglo[1]) == 0) 
		obj.value = parseInt(arreglo[0]);
	
	if(obj.value.substring(obj.value.length - 1,obj.value.length) == ".")  
		obj.value = obj.value.substring(0,obj.value.length - 1);
	
	if(isNaN(obj.value)) 
		obj.value = 0;
		
	if(obj.value=="0.0")
		obj.value = 0;
}


function checks(boton,obj){

if (document.getElementById(boton).value=='Marcar') {
	document.getElementById(boton).value='Desmarcar';
	var final=document.getElementById('cantidad_checks').value;
	for (i = 1; i <= final; i++){
		if(document.getElementById(obj+i)){
			document.getElementById(obj+i).checked = 1;
		}
	}
}
else {
	document.getElementById(boton).value='Marcar';
	var final=document.getElementById('cantidad_checks').value;
	for (i = 1; i <= final; i++)
		if(document.getElementById(obj+i)){
			document.getElementById(obj+i).checked = 0;
		}
	}
}



function imprimir(usuario,codigo,pagina) {
var ruta =pagina+"?usuario="+ usuario + "&&codigo=" + codigo ;
window.open(ruta,"imprimir","toolbar=no,scrollbars=no , width=650,height=650 ");
}
