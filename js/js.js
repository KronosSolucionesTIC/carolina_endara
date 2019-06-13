// JavaScript Document

function Agregar_html_consignacion(banco , numero ,valor_consignacion )
{
	var num = document.getElementById('val_inicial_cons');
	var lastRow = document.getElementById('fila_cons_' + num.value); 
	var soloLectura = "readonly";
//alert(lastRow)
	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_cons_' + num.value;				

		//nombre de banco
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"banco_consignacion_" + num.value + "\" value=\"" + banco + "\"> <span  class=\"textfield01\">" + banco + "</span> ";	
		newRow.appendChild(td);

		//numero de consignacion
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"num_consignacion_" + num.value + "\" value=\"" + numero + "\"> <span  class=\"textfield01\">" + numero + "</span> ";	
		newRow.appendChild(td);
		
		//valor de consignacion
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"valor_consignacion_" + num.value + "\" value=\"" + valor_consignacion + "\"> <span  class=\"textfield01\"><div align=\"right\">" + valor_consignacion + "</span></div> ";	
		newRow.appendChild(td);
				

		// boton q quita la fila
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_consignacion('" + newRow.id +"','val_inicial_cons','fila_cons_',"+ num.value +","+ valor_consignacion +");\"></div>";
		newRow.appendChild(td);
	
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		//suma los nuevos valores del credito
		document.getElementById("total_consignacion").value=  parseInt(document.getElementById("total_consignacion").value) +  parseInt(valor_consignacion);
		

	}
}


function removerFila_consignacion(id,val_inicial,filaName,id_borrar, total)
{
	//resta los nuevos valores
document.getElementById("total_consignacion").value=  parseInt(document.getElementById("total_consignacion").value) -  parseInt(total);
	//resta total neto  compra
	var num = document.getElementById(val_inicial);
	//alert(num)
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
		for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}




function Agregar_html_gasto(codigo_gasto , nombre_gas , valor_gas )
{
	var num = document.getElementById('val_inicial_gas');
	var lastRow = document.getElementById('fila_gas_' + num.value);
	var soloLectura = "readonly";
//alert(lastRow)
	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_gas_' + num.value;				

		//numero de gasto 
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_gasto_" + num.value + "\" value=\"" + codigo_gasto + "\"> <span  class=\"textfield01\">" + nombre_gas + "</span> ";	
		newRow.appendChild(td);
		
		//valor del gasto
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"valor_gasto_" + num.value + "\" value=\"" + valor_gas + "\"> <span  class=\"textfield01\"><div align=\"right\">" + valor_gas + "</span></div> ";	
		newRow.appendChild(td);
				

		// boton q quita la fila
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_gasto('" + newRow.id +"','val_inicial_gas','fila_gas_',"+ num.value +","+ valor_gas +");\"></div>";
		newRow.appendChild(td);
	
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		//suma los nuevos valores del credito
		document.getElementById("total_gasto").value=  parseInt(document.getElementById("total_gasto").value) +  parseInt(valor_gas);
		

	}
}


function removerFila_gasto(id,val_inicial,filaName,id_borrar, total)
{
	//resta los nuevos valores
	document.getElementById("total_gasto").value=  parseInt(document.getElementById("total_gasto").value) -  parseInt(total);
	//resta total neto  compra
	var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}



function Agregar_html_cheque(num_factura_che , nombre_banco , valor_che)
{

	var num = document.getElementById('val_inicial_che');
	var lastRow = document.getElementById('fila_che_' + num.value);
	var soloLectura = "readonly";

	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_che_' + num.value;				

		//numero de factura 
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"num_che_" + num.value + "\" value=\"" + num_factura_che + "\"> <span  class=\"textfield01\">" + num_factura_che + "</span> ";	
		newRow.appendChild(td);
		
		//nombre y codigo de cliente
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"nombre_banco_" + num.value + "\" value=\"" + nombre_banco + "\"> <span  class=\"textfield01\">" + nombre_banco + "</span> ";	
		newRow.appendChild(td);

		//valor de la factura
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"valor_che_" + num.value + "\" value=\"" + valor_che + "\"> <div align=\"right\"> <span  class=\"textfield100\">" + valor_che + "</span></div> ";	
		newRow.appendChild(td);
				

		// boton q quita la fila
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_cheque('" + newRow.id +"','val_inicial_che','fila_che_',"+ num.value +","+ valor_che +");\"></div>";
		newRow.appendChild(td);
	
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		//suma los nuevos valores del credito
		document.getElementById("total_chero").value=  parseInt(document.getElementById("total_chero").value) +  parseInt(valor_che);
		

	}
}


function removerFila_cheque(id,val_inicial,filaName,id_borrar, total)
{
	//resta los nuevos valores
	document.getElementById("total_chero").value=  parseInt(document.getElementById("total_chero").value) -  parseInt(total);
	//resta total neto  compra
		var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}


function Agregar_html_chero(factura,cliente_cod,cliente_nombre,valor)
{

	var num = document.getElementById('val_inicial_che');
	var lastRow = document.getElementById('fila_che_' + num.value);
	var soloLectura = "readonly";

	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_che_' + num.value;				

		//numero de factura 
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"num_factura_che_" + num.value + "\" value=\"" + factura + "\"> <span  class=\"textfield01\">" + factura + "</span> ";	
		newRow.appendChild(td);
		
		//nombre y codigo de cliente
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cod_cli_che_" + num.value + "\" value=\"" + cliente_cod + "\"> <span  class=\"textfield01\">" + cliente_nombre + "</span> ";	
		newRow.appendChild(td);

		//valor de la factura
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"val_factura_che_" + num.value + "\" value=\"" + valor + "\"> <div align=\"right\"> <span  class=\"textfield100\">" + valor + "</span></div> ";	
		newRow.appendChild(td);
				

		// boton q quita la fila
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_chero('" + newRow.id +"','val_inicial_che','fila_che_',"+ num.value +","+ valor +");\"></div>";
		newRow.appendChild(td);
	
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		//suma los nuevos valores del credito
		document.getElementById("total_chero").value=  parseInt(document.getElementById("total_chero").value) +  parseInt(valor);
		

	}
}


function removerFila_chero(id,val_inicial,filaName,id_borrar, total)
{
	//resta los nuevos valores
	document.getElementById("total_chero").value=  parseInt(document.getElementById("total_chero").value) -  parseInt(total);
	//resta total neto  compra
		var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}



function Agregar_html_cobro(factura,cliente_cod,cliente_nombre,valor,valor_descuento)
{

	var num = document.getElementById('val_inicial_cob');
	var lastRow = document.getElementById('fila_cob_' + num.value);
	var soloLectura = "readonly";

	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_cob_' + num.value;				

		//numero de factura 
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"num_factura_cob_" + num.value + "\" value=\"" + factura + "\"> <span  class=\"textfield01\">" + factura + "</span> ";	
		newRow.appendChild(td);
		
		//nombre y codigo de cliente
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cod_cli_cob_" + num.value + "\" value=\"" + cliente_cod + "\"> <span  class=\"textfield01\">" + cliente_nombre + "</span> ";	
		newRow.appendChild(td);

		//valor de la factura
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"val_factura_cob_" + num.value + "\" value=\"" + valor + "\"> <div align=\"right\"> <span  class=\"textfield100\">" + valor + "</span></div> ";	
		newRow.appendChild(td);
		
		//valor del descuento
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"valor_descuento_cob_" + num.value + "\" value=\"" + valor_descuento + "\"> <div align=\"right\"> <span  class=\"textfield100\">" + valor_descuento + "</span></div> ";	
		newRow.appendChild(td);
		
		// boton q quita la fila
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_cobro('" + newRow.id +"','val_inicial_cob','fila_cob_',"+ num.value +","+ valor +");\"></div>";
		newRow.appendChild(td);
	
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		//suma los nuevos valores del credito
		document.getElementById("total_cobro").value=  parseInt(document.getElementById("total_cobro").value) +  parseInt(valor) - parseInt(valor_descuento);
		

	}
}


function removerFila_cobro(id,val_inicial,filaName,id_borrar, total)
{
	//resta los nuevos valores
	document.getElementById("total_cobro").value=  parseInt(document.getElementById("total_cobro").value) -  parseInt(total);
	//resta total neto  compra
		var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}


function Agregar_html_credito(factura,cliente_cod,cliente_nombre,valor)
{

	var num = document.getElementById('val_inicial_cre');
	var lastRow = document.getElementById('fila_cre_' + num.value);
	var soloLectura = "readonly";

	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_cre_' + num.value;				

		//numero de factura 
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"num_factura_cre_" + num.value + "\" value=\"" + factura + "\"> <span  class=\"textfield01\">" + factura + "</span> ";	
		newRow.appendChild(td);
		
		//nombre y codigo de cliente
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cod_cli_cre_" + num.value + "\" value=\"" + cliente_cod + "\"> <span  class=\"textfield01\">" + cliente_nombre + "</span> ";	
		newRow.appendChild(td);

		//valor de la factura
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"val_factura_cre_" + num.value + "\" value=\"" + valor + "\"> <div align=\"right\"> <span  class=\"textfield100\">" + valor + "</span></div> ";	
		newRow.appendChild(td);
				

		// boton q quita la fila
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_credito('" + newRow.id +"','val_inicial_cre','fila_cre_',"+ num.value +","+ valor +");\"></div>";
		newRow.appendChild(td);
	
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		//suma los nuevos valores del credito
		document.getElementById("total_credito").value=  parseInt(document.getElementById("total_credito").value) +  parseInt(valor);
		

	}
}


function removerFila_credito(id,val_inicial,filaName,id_borrar, total)
{
	//resta los nuevos valores
	document.getElementById("total_credito").value=  parseInt(document.getElementById("total_credito").value) -  parseInt(total);
	//resta total neto  compra
		var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}


function Agregar_html_cargue (codigo_db,  codigo_fry, nombre_refe, valor_venta_unidad, descuento_prod ,valor_compra, iva, catidad_refe)
{

	var num = document.getElementById('val_inicial');
	var lastRow = document.getElementById('fila_' + num.value);
	var soloLectura = "readonly";
	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_' + num.value;				

		//nombre y codigo de la referencia
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_db_" + num.value + "\" value=\"" + codigo_db + "\"  > <INPUT type=\"hidden\" " + soloLectura + " class=\"textfield100\" name=\"codigo_fry_" + num.value + "\" value=\"" + codigo_fry + " - " +nombre_refe +  "\" >  <span  class=\"textfield01\">" + codigo_fry + " - " +  nombre_refe +  "</span> ";	
		newRow.appendChild(td);
		
		//cantidad
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\" class=\"textfield01\" name=\"cantidad_" + num.value + "\" value=\"" + catidad_refe +  "\" ><div align=\"right\"> <span  class=\"textfield01\">" + catidad_refe +  "</span></div>";	
		newRow.appendChild(td);
		
		//precio venta unidad
		//temp
		var valor_venta=0;
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"valor_venta_uidad_" + num.value + "\" value=\"" + valor_venta_unidad +  "\" ><div align=\"right\"> <span  class=\"textfield01\" >" + valor_venta_unidad +  "</span></div>";	
		total_venta=catidad_refe* valor_venta_unidad;
	
		newRow.appendChild(td);
		
		//descuento
		var valor_compra_temp =Math.round(((catidad_refe*valor_venta_unidad))/catidad_refe);
		descuento_prod = valor_compra_temp=Math.round((valor_compra_temp/100) * descuento_prod);
		//alert(descuento_prod)
		////////
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"total_descuento_" + num.value + "\" value=\"" + descuento_prod +  "\" ><div align=\"right\">  <span  class=\"textfield01\"  >" + descuento_prod +  "</span></div>";	
		newRow.appendChild(td);
		
		
		//precio iva
		var td = document.createElement('td');	
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"iva_" + num.value + "\" value=\"" + iva +  "\" ><div align=\"right\"> <span  class=\"textfield100\"  >" + iva +  "</span></div>";	
		newRow.appendChild(td);
		
		
		//costo p compra
		var valor_compra =Math.round(valor_venta_unidad-descuento_prod);
		//alert(valor_compra)
		pcompra = (catidad_refe * valor_compra);
		total_iva =Math.round(pcompra * iva /100);
		
		
		//pcompra = pcompra - total_iva;
		
		
		var td = document.createElement('td');	
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"valor_compra_" + num.value + "\" value=\"" + valor_compra +  "\" ><div align=\"right\"> <span  class=\"textfield100\"  >" + valor_compra +  "</span></div>";	
		newRow.appendChild(td);
		
		
		
		//valor del iva
		var td = document.createElement('td');	
		var neto_compra=Math.round(((valor_compra* catidad_refe)/100)* iva);
		//alert(neto_compra)
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"neto_iva_" + num.value + "\" value=\"" + neto_compra +  "\" ><div align=\"right\"> <span  class=\"textfield100\"  >" + neto_compra +  "</span></div>";	
		newRow.appendChild(td);
		
		
		nuevo_total=(valor_venta_unidad*catidad_refe)+neto_compra;
		//alert(nuevo_total)
		
		//precio total de compra
		var td = document.createElement('td');	
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"subtotal_compra_" + num.value + "\" value=\"" + pcompra +  "\" ><div align=\"right\"> <span  class=\"textfield100\"  >" + pcompra +  "</span></div>";	
		newRow.appendChild(td);
		
		
		//suma total venta del vendedor
		var venta_vendedor= parseInt(valor_venta_unidad * catidad_refe);
		var iva_vendedor= Math.round(((venta_vendedor)/100)* iva);
		var total_saldo_vendedor= parseInt(venta_vendedor + iva_vendedor);
		document.getElementById("total_nuevo_saldo").value=  parseInt(document.getElementById("total_nuevo_saldo").value) +  parseInt(total_saldo_vendedor);
		//suma total venta del vendedor

		// boton q quita la fila
		//alert('fila_'+ num.value)
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_cargue('" + newRow.id +"','val_inicial','fila_',"+ num.value +","+ nuevo_total +","+ pcompra +","+ total_iva +"," +iva+ ","+ total_saldo_vendedor +");\"></div>";
		newRow.appendChild(td);
				
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		
		//suma los nuevos valores
		//suma total neto  compra
		document.getElementById("neto").value=  parseInt(document.getElementById("neto").value) +  parseInt(pcompra );
		//suma de iva
		document.getElementById("todoiva").value=  parseInt(document.getElementById("todoiva").value) +  parseInt(total_iva );
		if(iva==16) {
		//alert(iva)	
			document.getElementById("todoiva1").value=  parseInt(document.getElementById("todoiva1").value) +  parseInt(total_iva );
		}
		if(iva==10) {
		//alert(iva)	
			document.getElementById("todoiva2").value=  parseInt(document.getElementById("todoiva2").value) +  parseInt(total_iva );
		}
		//suma del total
		document.getElementById("todocompra").value=  parseInt(document.getElementById("todocompra").value) +  parseInt(pcompra + total_iva);
		
	
	}
}




function removerFila_cargue(id,val_inicial,filaName,id_borrar, total_nuevo_saldo,pcompra,total_iva,iva_porcent,total_saldo_vendedor)
{
	
	//resta total neto  compra
	document.getElementById("neto").value=  parseInt(document.getElementById("neto").value) -  parseInt(pcompra );
	//suma de iva
	document.getElementById("todoiva").value=  parseInt(document.getElementById("todoiva").value) -  parseInt(total_iva );
	if(iva_porcent==16) {
		//alert(iva)	
		document.getElementById("todoiva1").value=  parseInt(document.getElementById("todoiva1").value) -  parseInt(total_iva );
	}
	if(iva_porcent==10) {
	//alert(iva)	
		document.getElementById("todoiva2").value=  parseInt(document.getElementById("todoiva2").value) -  parseInt(total_iva );
	}

	//suma del total
	document.getElementById("todocompra").value = parseInt(document.getElementById("todocompra").value) - (parseInt(pcompra) + parseInt(total_iva));
	//document.getElementById("todocompra").value=  parseInt(document.getElementById("todocompra").value) -  parseInt(pcompra + total_iva);
	
	//resta el saldo del vendedor
	document.getElementById("total_nuevo_saldo").value=  parseInt(document.getElementById("total_nuevo_saldo").value) -  parseInt(total_saldo_vendedor );
	
	
	var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}



function Agregar_html_inventario(codigo_db,codigo_fry,nombre_refe,valor_venta,valor_compra,iva, catidad_refe,tipo_unidad)
{	

	var num = document.getElementById('val_inicial');
	var lastRow = document.getElementById('fila_' + num.value);
	var soloLectura = "readonly";
	
	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_' + num.value;				

		//nombre y codigo de la referencia
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_db_" + num.value + "\" value=\"" + codigo_db + "\"  > <INPUT type=\"hidden\" " + soloLectura + " class=\"textfield100\" name=\"codigo_fry_" + num.value + "\" value=\"" + codigo_fry + " - " +nombre_refe +  "\" > <span  class=\"textfield01\">" + codigo_fry + " - " +  nombre_refe +  "</span>";	
		newRow.appendChild(td);
		
		// IVA 
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"iva_" + num.value + "\" value=\"" + iva +  "\" ><div align=\"right\"> <span  class=\"textfield100\"  >" + iva +  "%</span></div>";	
		newRow.appendChild(td);
		
		//cantidad
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\" class=\"textfield01\" name=\"cantidad_" + num.value + "\" value=\"" + catidad_refe +  "\" ><div align=\"right\"> <span  class=\"textfield01\">" + catidad_refe +  "</span></div>";	
		newRow.appendChild(td);
		
		//precio venta
		var td = document.createElement('td');
		valor_venta=Math.round(valor_venta);
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"valor_venta_" + num.value + "\" value=\"" + valor_venta +  "\" ><div align=\"right\"> <span  class=\"textfield01\" >" + valor_venta +  "</span></div>";	
		total_venta=parseInt(catidad_refe* valor_venta);
		nuevo_total= parseInt(parseInt(total_venta * iva)/100)+ total_venta;
		newRow.appendChild(td);
		
		//precio iva
		var td = document.createElement('td');	
		pcompra = (catidad_refe * valor_venta);
		total_iva=(pcompra  /100);
		total_iva=(total_iva * iva) ;
		total_compra_item = parseInt(pcompra + total_iva);
		
		// total iva
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"total_iva_" + num.value + "\" value=\"" + iva +  "\" ><div align=\"right\"> <span  class=\"textfield100\"  >" + parseInt(total_iva) +  "</span></div>";	
		newRow.appendChild(td);

		//pcompra =total_iva;	
		
//		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"iva_" + num.value + "\" value=\"" + iva +  "\" ><div align=\"right\"> <span  class=\"textfield100\"  >" + total_iva +  "</span></div>";	
//		newRow.appendChild(td);
		
		//precio total de compra
		var td = document.createElement('td');	
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"total_compra_" + num.value + "\" value=\"" + pcompra +  "\" ><div align=\"right\"> <span  class=\"textfield100\"  >" + parseInt(total_compra_item) +  "</span></div>";	
		newRow.appendChild(td);
		
		// boton q quita la fila
		//alert('fila_'+ num.value)
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_inventario('" + newRow.id +"','val_inicial','fila_',"+ num.value +","+ total_compra_item +","+ total_compra_item +","+ total_iva +");\"></div>";
		newRow.appendChild(td);
				
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		//suma los nuevos valores
		document.getElementById("total_nuevo_saldo").value=  parseInt(document.getElementById("total_nuevo_saldo").value) +  parseInt(total_compra_item);
		//suma total neto  compra
	}
}



function removerFila_inventario(id,val_inicial,filaName,id_borrar, total_nuevo_saldo,pcompra,total_iva)
{
	//resta los nuevos valores
	//alert(total_nuevo_saldo)
	//return false;
	document.getElementById("total_nuevo_saldo").value=  parseInt(document.getElementById("total_nuevo_saldo").value) -  parseInt(total_nuevo_saldo);
	//resta total neto  compra
		var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}

function Agregar_html_cargue_resumen(codigo_db,codigo_fry,nombre_refe,valor_venta,valor_compra,iva, catidad_refe)
{

	var num = document.getElementById('val_inicial');
	var lastRow = document.getElementById('fila_' + num.value);
	var soloLectura = "readonly";
	
	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_' + num.value;				

		//nombre y codigo de la referencia
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_db_" + num.value + "\" value=\"" + codigo_db + "\"  > <INPUT type=\"hidden\" " + soloLectura + " class=\"textfield100\" name=\"codigo_fry_" + num.value + "\" value=\"" + codigo_fry + " - " +nombre_refe +  "\" >  <span  class=\"textfield01\">" + codigo_fry + " - " +  nombre_refe +  "</span> ";	
		newRow.appendChild(td);
		
		//cantidad
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\" class=\"textfield01\" name=\"cantidad_" + num.value + "\" value=\"" + catidad_refe +  "\" ><div align=\"right\"> <span  class=\"textfield01\">" + catidad_refe +  "</span></div>";	
		newRow.appendChild(td);
		
		//precio venta
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"valor_venta_" + num.value + "\" value=\"" + valor_venta +  "\" ><div align=\"right\"> <span  class=\"textfield01\" >" + valor_venta +  "</span></div><INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"valor_compra_" + num.value + "\" value=\"" + valor_compra +  "\" ><INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"iva_" + num.value + "\" value=\"" + iva +  "\" >";	
		total_venta=catidad_refe* valor_venta;
		nuevo_total=((total_venta * iva)/100)+ total_venta;
		newRow.appendChild(td);
		
		//precio compra
		/*var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"valor_compra_" + num.value + "\" value=\"" + valor_compra +  "\" ><div align=\"right\">  <span  class=\"textfield01\"  >" + valor_compra +  "</span></div>";	
		newRow.appendChild(td);*/
		
		
		
		//precio iva
		//var td = document.createElement('td');	
		pcompra = catidad_refe* valor_compra;
		total_iva=parseInt(pcompra * iva /100);
		//td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"iva_" + num.value + "\" value=\"" + iva +  "\" ><div align=\"right\"> <span  class=\"textfield100\"  >" + iva +  "</span></div>";	
		//newRow.appendChild(td);
		
		//precio total de compra
		var td = document.createElement('td');	
		td.innerHTML  = "<INPUT type=\"hidden\" " + soloLectura + " class=\"textfield01\" name=\"total_compra_" + num.value + "\" value=\"" + pcompra +  "\" ><div align=\"right\"> <span  class=\"textfield100\"  >" + pcompra +  "</span></div>";	
		newRow.appendChild(td);
		

		// boton q quita la fila
		//alert('fila_'+ num.value)
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_cargue('" + newRow.id +"','val_inicial','fila_',"+ num.value +","+ nuevo_total +","+ pcompra +","+ total_iva +");\"></div>";
		newRow.appendChild(td);
				
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		//suma los nuevos valores
		//suma total venta
		document.getElementById("total_nuevo_saldo").value=  parseInt(document.getElementById("total_nuevo_saldo").value) +  parseInt(nuevo_total );
		//suma total neto  compra
		document.getElementById("neto").value=  parseInt(document.getElementById("neto").value) +  parseInt(pcompra );
		//suma de iva
		document.getElementById("todoiva").value=  parseInt(document.getElementById("todoiva").value) +  parseInt(total_iva );
		//suma del total
		document.getElementById("todocompra").value=  parseInt(document.getElementById("todocompra").value) +  parseInt(pcompra + total_iva);
	}
}




function addDocCmp(referncia,nombre,cantidad_ref,total,costo,serial){
		
	var cantidad=parseInt(document.getElementById('cant_items').value);
	document.getElementById('cant_items').value=cantidad+1;
//	agregar_item();
	
	var num = document.getElementById('valDoc_inicial');
	var lastRow = document.getElementById('filaDoc_' + num.value);

	if(lastRow){
		//alert(lastRow)		
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'filaDoc_' + num.value;
		newRow.className="ctablagris";
		

		var td = document.createElement('td');
		td.style.width="195px";
		td.className="ctablablanc"; 

		//item del codigo
		var elem = document.createElement("input");
		elem.type = 'hidden';
		elem.id = elem.name = 'codigo_' + num.value;
		elem.value=referncia;
		td.appendChild(elem);

		// id para saber coomo eliminar
		var elem = document.createElement("input");
	//	elem.type = 'text';
		elem.type = 'hidden';
		elem.id = elem.name = 'codigo_unico' ;
		elem.value=newRow.id;
		td.appendChild(elem);
		
		
		//textarea   para guardar todos los seriales
		var elem = document.createElement("textarea");
		elem.style.display = "none";
		//elem.id = elem.name = 'serial_' + num.value;
		elem.id = elem.name ='text_serial_' + num.value;
		var nombresito=elem.name;
		document.getElementById('campo_guardar').value="";
		document.getElementById('campo_guardar').value=nombresito;
		
		
	//	elem.value=elem.id;
		td.appendChild(elem);

		var elem = document.createElement("input");
		//elem.type = 'text';
		elem.type = 'hidden';
		elem.id = elem.name = 'nombre_unico' ;
		elem.value=nombresito;
		td.appendChild(elem);

		
		//nombre de la referencias
		var elem1 = document.createElement("input");
		elem1.size = 20;
		elem1.className = 'textfield002';
		elem1.readOnly=1;//setAttribute("readonly","1"); 
		elem1.id = elem1.name = 'nombreref_' + num.value;
		elem1.value=nombre;
		td.appendChild(elem1);
		newRow.appendChild(td)
		
		//cantidad
		var td = document.createElement('td');
		td.align = 'center';
		td.style.width="50px";
		var elem = document.createElement("input");
		elem.className = 'textfield01';
		elem.readOnly=1;
		elem.size = 12;
		elem.id = elem.name = 'cantidad' + num.value;
		elem.value=cantidad_ref;
		td.appendChild(elem);
		newRow.appendChild(td)
		
		//costo
		var td = document.createElement('td');
		td.align = 'center';
		td.style.width="50";
		var elem = document.createElement("input");
		elem.className = 'textfield01';
		elem.readOnly=1;
		elem.size = 15;
		elem.id = elem.name = 'costo_' + num.value;
		elem.value=costo;
		td.appendChild(elem);
		newRow.appendChild(td)

		//total
		var td = document.createElement('td');
		td.align = 'center';
		td.style.width="60";
		var elem = document.createElement("input");
		elem.className = 'textfield01';
		elem.readOnly=1;
		elem.size = 15;
		elem.id = elem.name = 'total' + num.value;
		elem.value=total;
		td.appendChild(elem);
		newRow.appendChild(td)

		var idText = 'nameDocCampo_' + num.value;
		newRow.appendChild(td); //fin del ETIQUETA
		
		//boton eliminar fila
		var td = document.createElement('td');
		td.align = 'center';
		var elem = document.createElement("input");
		elem.type = 'button';
		elem.className = 'botones';
		elem.value = ' - ';
		elem.title = 'Remover campos';
		elem.onclick = function (){removeDocCmp(newRow.id);}
		td.appendChild(elem);
		//boton consultar seriales
		if (serial>0) {
			var elem = document.createElement("input");
			elem.type = 'button';
			elem.className = 'botones';
			elem.value = ' ! ';
			elem.title = 'Seriales';
			elem.onclick = function (){ver_seriales(referncia,nombre,nombresito);}
			//td.appendChild(elem);
			//newRow.appendChild(td); //fin del ETIQUETA
			td.appendChild(elem);
		}
		newRow.appendChild(td); //fin del ETIQUETA
		
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
	}
}


function restar() {
	document.getElementById('cant_items').value=parseInt(document.getElementById('cant_items').value)-1;
}


/*function relacion_serial(cantidad,referncia,nombre){
	document.getElementById('ref_serial_').value=referncia;
	document.getElementById('serial_nombre_').innerHTML=nombre;
	
	var cantidad_ser=parseInt(cantidad);
	for (i=0; i< cantidad_ser; i++)
	{
		var lastRow = document.getElementById('pongale_'+ i);
		var newTR = i + 1;
		if(lastRow){
			var newRow = document.createElement('tr');
			newRow.id = 'pongale_' + parseInt(newTR);
			newRow.className="ctablagris";
			
			var td = document.createElement('td');
			td.style.width="80px";
			td.className="ctablablanc"; 
	
			var elem = document.createElement("strong");
			elem.appendChild(document.createTextNode('Numero: ' + newTR));
			td.appendChild(elem);
			newRow.appendChild(td)
	
			var td = document.createElement('td');
			td.style.width="80px";
			td.className="ctablablanc"; 
	
			var elem1 = document.createElement("input");
			elem1.size = 20;
			elem1.className = 'textfield002';
			elem1.id = elem1.name = 'serial_ref_' + newTR;
			td.appendChild(elem1);
			newRow.appendChild(td)
	
			lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);	
			
		}
	} document.getElementById('catidad_seriales').value = cantidad;
}
*/

/*function guardar_serial(){
	var refe=document.getElementById('ref_serial_').value;
	var caja_texto=document.getElementById('campo_guardar').value;
	var serial_final = document.getElementById('catidad_seriales');
	var valorTextArea = "";
	var valores_serial = new Array ();
	//VERIFICA SI ESTAN LLENOS TODOS LOS SERIALES
	for (i = 1; i <= serial_final.value; i++ ){
		var serial_text = document.getElementById('serial_ref_' + i);
		valores_serial[i-1]=serial_text.value;
		if (serial_text.value==""){
			alert("Complete los Seriales, Gracias");
			serial_text.focus();
			return false;
		}
	}

	//VERIFICA SI QUE NO SE REPITAN LOS SERIALES
	for (i = 0; i <= serial_final.value - 1 ; i++ ){
		valores_serial=valores_serial.sort()
		if (valores_serial[i]==valores_serial[i+1])
		{
			alert("Existen Seriales repetidos ");
			return false;
		}
	}


	for (i = 1; i <= serial_final.value; i++ ){
		var serial_text = document.getElementById('serial_ref_' + i);
		if(valorTextArea != "")	valorTextArea = valorTextArea + "|";
		valorTextArea = valorTextArea + serial_text.value;
		
		var fila = document.getElementById('pongale_' + i);
		fila.parentNode.removeChild(fila);		
	}

	document.getElementById(caja_texto).value = valorTextArea;
	serial_final.value = 0;
	document.getElementById('campo_guardar').value="";
	document.getElementById('relacion').style.display = 'none';
	document.getElementById('total').style.display = 'inline';

}
*/

function limpiar(){
	var mas=parseInt(document.getElementById('cant_items').value) -1;
	document.getElementById('cant_items').value=mas;
	var id=document.getElementById('codigo_unico').value;
	var fila = document.getElementById(id);	
	fila.parentNode.removeChild(fila);
	document.getElementById('relacion').style.display = 'none';
	document.getElementById('total').style.display = 'inline';	
	var refe=document.getElementById('ref_serial_').value;
	var serial_final = document.getElementById('catidad_seriales');
	for (i = 1; i <= serial_final.value; i++ ){
		var serial_text = document.getElementById('serial_ref_' + i);
		var fila = document.getElementById('pongale_' + i);
		fila.parentNode.removeChild(fila);		
	}
}






























































function Agregar_html_entrada ()
{

	var num = document.getElementById('val_inicial');
	var lastRow = document.getElementById('fila_' + num.value);
	var soloLectura = "readonly";
	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_' + num.value;				

		//tipo de prodcuto
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_tipo_prodcuto_" + num.value + "\" value=\"" + document.getElementById("tipo_producto").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("tipo_producto").options[document.getElementById("tipo_producto").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
				
		//proveedor
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_marca_" + num.value + "\" value=\"" + document.getElementById("marca").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("marca").options[document.getElementById("marca").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);

		//referencia
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_referencia_" + num.value + "\" value=\"" + document.getElementById("combo_referncia").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("combo_referncia").options[document.getElementById("combo_referncia").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);

		//codigo de la referencia
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_fry_" + num.value + "\" value=\"" + document.getElementById("codigo_fry").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("codigo_fry").value +  "</span> ";	
		newRow.appendChild(td);
		
		//cantidad referencias
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cantidad_ref_" + num.value + "\" value=\"" + document.getElementById("cantidad").value + "\" >  <span  class=\"textfield01\" align='right'>" + document.getElementById("cantidad").value +  "</span> ";	
		newRow.appendChild(td);		
		
		// boton q quita la fila
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_entrada('" + newRow.id +"','val_inicial','fila_' );\"></div>";
		newRow.appendChild(td);
		
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
	
	}
}


function removerFila_entrada(id,val_inicial,filaName)
{
	//resta total neto  compra
	var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
	
	
}




function Agregar_html_traslado ()
{

	var num = document.getElementById('val_inicial');
	var lastRow = document.getElementById('fila_' + num.value);
	var soloLectura = "readonly";
	if(lastRow){

		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_' + num.value;				
		
		
		//proveedor
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_marca_" + num.value + "\" value=\"" + document.getElementById("marca").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("marca").options[document.getElementById("marca").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
		
		//tipo de prodcuto
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_tipo_prodcuto_" + num.value + "\" value=\"" + document.getElementById("tipo_producto").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("tipo_producto").options[document.getElementById("tipo_producto").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
				
		//referencia
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_referencia_" + num.value + "\" value=\"" + document.getElementById("combo_referncia").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("combo_referncia").options[document.getElementById("combo_referncia").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);


		//codigo de la referencia
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_fry_" + num.value + "\" value=\"" + document.getElementById("codigo_fry").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("codigo_fry").value +  "</span> ";	
		newRow.appendChild(td);
		
		
		//cantidad referencias
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cantidad_ref_" + num.value + "\" value=\"" + document.getElementById("cantidad").value + "\" ><INPUT type=\"hidden\"  name=\"cod_linea_" + num.value + "\" value=\"" + document.getElementById("cod_linea").value + "\" >   <span  class=\"textfield01\" align='right'>" + document.getElementById("cantidad").value +  "</span> ";	
		newRow.appendChild(td);
				
		// boton q quita la fila
		//var total_compra_item=parseInt(document.getElementById("costo").value);
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_traslado('" + newRow.id +"','val_inicial','fila_','" + 0 + "');\"></div>";
		newRow.appendChild(td);
		
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
	//document.getElementById("todocompra").value = parseInt(document.getElementById("todocompra").value) + parseInt(document.getElementById("costo").value);
		
	
	}
}


function removerFila_traslado(id,val_inicial,filaName,total_compra)
{
	//resta total neto  compra
	//document.getElementById("todocompra").value =parseInt(document.getElementById("todocompra").value) - parseInt(total_compra);
	var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}




function Agregar_html_venta ()
{
	
	var num = document.getElementById('val_inicial');
	var lastRow = document.getElementById('fila_' + num.value);
	var soloLectura = "readonly";
	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_' + num.value;				

		//tipo de prodcuto
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_marca_" + num.value + "\" value=\"" + document.getElementById("marca").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("marca").options[document.getElementById("marca").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
			
		//proveedor
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_tipo_prodcuto_" + num.value + "\" value=\"" + document.getElementById("tipo_producto").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("tipo_producto").options[document.getElementById("tipo_producto").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);

		//referencia
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_referencia_" + num.value + "\" value=\"" + document.getElementById("combo_referncia").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("combo_referncia").options[document.getElementById("combo_referncia").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
		
		
		
		//codigo de la referencia
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_fry_" + num.value + "\" value=\"" + document.getElementById("codigo_fry").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("codigo_fry").value +  "</span> ";	
		newRow.appendChild(td);

		//TALLA
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_talla_" + num.value + "\" value=\"" + document.getElementById("talla").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("talla").options[document.getElementById("talla").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
				
		//COLOR
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_color_" + num.value + "\" value=\"" + document.getElementById("color").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("color").options[document.getElementById("color").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
	
		//cantidad referencias
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cantidad_ref_" + num.value + "\" value=\"" + document.getElementById("cantidad").value + "\" >  <span  class=\"textfield01\"><div align=\"right\">" + document.getElementById("cantidad").value +  "</div></span> ";	
		newRow.appendChild(td);

		//descuento
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"descuento_" + num.value + "\" value=\"" + document.getElementById("descuento").value + "\" >  <span  class=\"textfield01\"><div align=\"right\">" + document.getElementById("descuento").value +  "</div></span> ";	
		newRow.appendChild(td);
		
		//valor referencias
		var valor_refe_total = document.getElementById("valor_lista").value * document.getElementById("cantidad").value;
		var desc = document.getElementById("descuento").value * valor_refe_total / 100;
		var valor_refe_lista_total = valor_refe_total - desc;
		var valor_ref_lista_unitario=document.getElementById("valor_lista").value ;
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"costo_ref_uni_" + num.value + "\" value=\"" + valor_ref_lista_unitario + "\" ><INPUT type=\"hidden\"  name=\"costo_ref_total_" + num.value + "\" value=\"" + valor_refe_lista_total + "\" >  <span  class=\"textfield01\"><div align=\"right\">" + valor_ref_lista_unitario +  "</div></span> ";	
		newRow.appendChild(td);

		var total_compra_item=parseInt(valor_refe_lista_total);
		
		
		var no_repite= document.getElementById("combo_referncia").value;
		
		
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_venta('" + newRow.id +"','val_inicial','fila_','" + total_compra_item + "' ,'" + desc + "', '"+ no_repite +"');\"></div>";
		newRow.appendChild(td);
		
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		document.getElementById("subtotal").value=parseInt(document.getElementById("subtotal").value) + parseInt(valor_refe_total);
		document.getElementById("desc_tot").value=parseInt(document.getElementById("desc_tot").value) + parseInt(desc);
		document.getElementById("todocompra").value=parseInt(document.getElementById("todocompra").value) + parseInt(total_compra_item);
		document.getElementById("saldo").value=parseInt(document.getElementById("saldo").value) + parseInt(total_compra_item);
		
		document.getElementById("tipo_referencias").value=document.getElementById("tipo_referencias").value + '@'+ document.getElementById("combo_referncia").value;

	}
}


function removerFila_venta(id,val_inicial,filaName,total_compra,descuento,no_repite)
{
	//resta total neto  compra
	document.getElementById("todocompra").value =parseInt(document.getElementById("todocompra").value) - parseInt(total_compra);
	document.getElementById("saldo").value =parseInt(document.getElementById("saldo").value) - parseInt(total_compra);
	document.getElementById("subtotal").value =parseInt(document.getElementById("subtotal").value) - parseInt(total_compra) - parseInt(descuento);
	document.getElementById("desc_tot").value=parseInt(document.getElementById("desc_tot").value) - parseInt(descuento);
	var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
	anti_trampa_borrar(no_repite);
}

function Agregar_html_venta2 ()
{
	
	var num = document.getElementById('val_inicial');
	var lastRow = document.getElementById('fila_' + num.value);
	var soloLectura = "readonly";
	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_' + num.value;				

		//tipo de prodcuto
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_marca_" + num.value + "\" value=\"" + document.getElementById("marca").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("marca").options[document.getElementById("marca").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
			
		//proveedor
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_tipo_prodcuto_" + num.value + "\" value=\"" + document.getElementById("tipo_producto").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("tipo_producto").options[document.getElementById("tipo_producto").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);

		//referencia
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_referencia_" + num.value + "\" value=\"" + document.getElementById("combo_referncia").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("combo_referncia").options[document.getElementById("combo_referncia").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
		
		
		
		//codigo de la referencia
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_fry_" + num.value + "\" value=\"" + document.getElementById("codigo_fry").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("codigo_fry").value +  "</span> ";	
		newRow.appendChild(td);

		//TALLA
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_talla_" + num.value + "\" value=\"" + document.getElementById("talla").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("talla").options[document.getElementById("talla").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
				
		//COLOR
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"codigo_color_" + num.value + "\" value=\"" + document.getElementById("color").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("color").options[document.getElementById("color").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
	
		//cantidad referencias
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cantidad_ref_" + num.value + "\" value=\"" + document.getElementById("cantidad").value + "\" >  <span  class=\"textfield01\"><div align=\"right\">" + document.getElementById("cantidad").value +  "</div></span> ";	
		newRow.appendChild(td);

		//descuento
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"descuento_" + num.value + "\" value=\"" + document.getElementById("descuento").value + "\" >  <span  class=\"textfield01\"><div align=\"right\">" + document.getElementById("descuento").value +  "</div></span> ";	
		newRow.appendChild(td);
		
		//valor referencias
		var valor_refe_total = document.getElementById("valor_lista").value * document.getElementById("cantidad").value;
		var desc = document.getElementById("descuento").value * valor_refe_total / 100;
		var valor_refe_lista_total = valor_refe_total - desc;
		var valor_ref_lista_unitario=document.getElementById("valor_lista").value ;
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"costo_ref_uni_" + num.value + "\" value=\"" + valor_ref_lista_unitario + "\" ><INPUT type=\"hidden\"  name=\"costo_ref_total_" + num.value + "\" value=\"" + valor_refe_lista_total + "\" >  <span  class=\"textfield01\"><div align=\"right\">" + valor_ref_lista_unitario +  "</div></span> ";	
		newRow.appendChild(td);

		var total_compra_item=parseInt(valor_refe_lista_total);
		
		
		var no_repite= document.getElementById("combo_referncia").value;
		
		
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_venta2('" + newRow.id +"','val_inicial','fila_','" + total_compra_item + "' ,'" + desc + "', '"+ no_repite +"');\"></div>";
		newRow.appendChild(td);
		
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		document.getElementById("subtotal").value=parseInt(document.getElementById("subtotal").value) + parseInt(valor_refe_total);
		document.getElementById("desc_tot").value=parseInt(document.getElementById("desc_tot").value) + parseInt(desc);
		document.getElementById("todocompra").value=parseInt(document.getElementById("todocompra").value) + parseInt(total_compra_item);
		document.getElementById("saldo").value = parseInt(document.getElementById("saldo").value) + parseInt(total_compra_item);
		document.getElementById("saldo_ant").value = parseInt(document.getElementById("saldo_ant").value) + parseInt(total_compra_item);
		document.getElementById("saldo_nuevo").value = parseInt(document.getElementById("saldo_nuevo").value) + parseInt(total_compra_item);
		document.getElementById("tipo_referencias").value=document.getElementById("tipo_referencias").value + '@'+ document.getElementById("combo_referncia").value;

	}
}


function removerFila_venta2(id,val_inicial,filaName,total_compra,descuento,no_repite)
{
	//resta total neto  compra
	document.getElementById("todocompra").value =parseInt(document.getElementById("todocompra").value) - parseInt(total_compra);
	document.getElementById("saldo").value =parseInt(document.getElementById("saldo").value) - parseInt(total_compra);
	document.getElementById("subtotal").value =parseInt(document.getElementById("subtotal").value) - parseInt(total_compra) - parseInt(descuento);
	document.getElementById("desc_tot").value=parseInt(document.getElementById("desc_tot").value) - parseInt(descuento);
	document.getElementById("saldo_ant").value = parseInt(document.getElementById("saldo_ant").value) - parseInt(total_compra);
	document.getElementById("saldo_nuevo").value = parseInt(document.getElementById("saldo_nuevo").value) - parseInt(total_compra);
	var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
	anti_trampa_borrar(no_repite);
}

function anti_trampa_borrar(no_repite)
{	
	var myString =document.getElementById("tipo_referencias").value;
	myString=myString.replace(no_repite,"---");
	document.getElementById("tipo_referencias").value=myString;
}

function Agregar_html_ruta()
{
	
	var num = document.getElementById('val_inicial');
	var lastRow = document.getElementById('fila_' + num.value);
	var soloLectura = "readonly";
	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_' + num.value;				

		//tipo de prodcuto
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\" id=\"codigo_ruta_" + num.value + "\" name=\"codigo_ruta_" + num.value + "\" value=\"" + document.getElementById("ruta").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("ruta").options[document.getElementById("ruta").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
		
		// boton q quita la fila		
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_ruta('" + newRow.id +"','val_inicial','fila_');\"></div>";
		newRow.appendChild(td);
		
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
	}
}


function removerFila_ruta(id,val_inicial,filaName)
{
	var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}

function Agregar_html_cuenta ()
{
	var num = document.getElementById('val_inicial');
	var lastRow = document.getElementById('fila_' + num.value);
	var soloLectura = "readonly";
	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_' + num.value;	
				
		//TERCERO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cod_pro_" + num.value + "\" value=\"" + document.getElementById("proveedor").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("proveedor").options[document.getElementById("proveedor").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);			

		//CUENTA
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cod_auxiliar_" + num.value + "\" value=\"" + document.getElementById("auxiliar").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("auxiliar").options[document.getElementById("auxiliar").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
		
		//CONCEPTO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cod_concepto_" + num.value + "\" value=\"" + document.getElementById("concepto").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("concepto").value +  "</span> ";	
		newRow.appendChild(td);
		
		//DEBITO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  id=\"debito_" + num.value + "\" value=\"" + document.getElementById("debito").value + "\" name=\"debito_" + num.value + "\" value=\"" + document.getElementById("debito").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("debito").value  +  "</span> ";	
		newRow.appendChild(td);
		
		//CREDITO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  id=\"credito_" + num.value + "\" value=\"" + document.getElementById("credito").value + "\"  name=\"credito_" + num.value + "\" value=\"" + document.getElementById("credito").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("credito").value  +  "</span> ";	
		newRow.appendChild(td);
		
		debito = parseFloat(document.getElementById("debito").value)
		credito = parseFloat(document.getElementById("credito").value)
		// boton q quita la fila		
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_cuenta('" + newRow.id +"','val_inicial','fila_', '" + debito +"','" + credito +"');\"></div>";
		newRow.appendChild(td);
				
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		document.getElementById("total_debito").value=parseFloat(document.getElementById("total_debito").value) + debito;
		document.getElementById("total_credito").value=parseFloat(document.getElementById("total_credito").value) + credito;
	}
}

function removerFila_cuenta(id,val_inicial,filaName,debito,credito)
{
	//RESTA EL VALOR DEL ITEM
	document.getElementById("total_debito").value=parseFloat(document.getElementById("total_debito").value) - debito;
	document.getElementById("total_credito").value=parseFloat(document.getElementById("total_credito").value) - credito;
	var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}


function Agregar_html_cuenta2 ()
{
	var num = document.getElementById('val_inicial');
	var lastRow = document.getElementById('fila_' + num.value);
	var soloLectura = "readonly";
	if(lastRow){
		num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_' + num.value;
		
		//CENTRO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"centro_" + num.value + "\" value=\"" + document.getElementById("centro").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("centro").options[document.getElementById("centro").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);	
					
		
		//TERCERO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cod_pro_" + num.value + "\" value=\"" + document.getElementById("proveedor").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("proveedor").options[document.getElementById("proveedor").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);			
		
		//CONCEPTO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cod_concepto_" + num.value + "\" value=\"" + document.getElementById("concepto").value + "\" > <INPUT type=\"hidden\"  name=\"cod_auxiliar_" + num.value + "\" value=\"" + document.getElementById("auxiliar").value + "\" > <span  class=\"textfield01\">" + document.getElementById("concepto").options[document.getElementById("concepto").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);
		
		//DEBITO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"debito_" + num.value + "\" value=\"" + document.getElementById("debito").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("debito").value  +  "</span> ";	
		newRow.appendChild(td);
		
		//CREDITO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"credito_" + num.value + "\" value=\"" + document.getElementById("credito").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("credito").value  +  "</span> ";	
		newRow.appendChild(td);
		
		debito = parseFloat(document.getElementById("debito").value)
		credito = parseFloat(document.getElementById("credito").value)
		// boton q quita la fila		
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_cuenta2('" + newRow.id +"','val_inicial','fila_', '" + debito +"','" + credito +"');\"></div>";
		newRow.appendChild(td);
				
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		document.getElementById("total_debito").value=parseFloat(document.getElementById("total_debito").value) + debito;
		document.getElementById("total_credito").value=parseFloat(document.getElementById("total_credito").value) + credito;
	
			num.value = parseInt(num.value) + 1;
		var newRow = document.createElement('tr');
		newRow.id = 'fila_' + num.value;
		
		//CENTRO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"centro_" + num.value + "\" value=\"" + document.getElementById("centro").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("centro").options[document.getElementById("centro").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);	
					
		
		//TERCERO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cod_pro_" + num.value + "\" value=\"" + document.getElementById("proveedor").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("proveedor").options[document.getElementById("proveedor").selectedIndex].text +  "</span> ";	
		newRow.appendChild(td);			
		
		//CONCEPTO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"cod_concepto_" + num.value + "\" value=\"" + 50 + "\" > <INPUT type=\"hidden\"  name=\"cod_auxiliar_" + num.value + "\" value=\"" + 5 + "\" > <span  class=\"textfield01\">" + 'PAGOS DEL DIA' +  "</span> ";	
		newRow.appendChild(td);
		
		//DEBITO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"debito_" + num.value + "\" value=\"" + document.getElementById("credito").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("credito").value  +  "</span> ";	
		newRow.appendChild(td);
		
		//CREDITO
		var td = document.createElement('td');
		td.innerHTML  = "<INPUT type=\"hidden\"  name=\"credito_" + num.value + "\" value=\"" + document.getElementById("debito").value + "\" >  <span  class=\"textfield01\">" + document.getElementById("debito").value  +  "</span> ";	
		newRow.appendChild(td);
		
		credito= parseFloat(document.getElementById("debito").value)
		debito = parseFloat(document.getElementById("credito").value)
		// boton q quita la fila		
		var td = document.createElement('td');
		td.innerHTML = "<div align=\"center\"><INPUT type=\"button\" class=\"botones\" value=\"  -  \" onclick=\"removerFila_cuenta2('" + newRow.id +"','val_inicial','fila_', '" + debito +"','" + credito +"');\"></div>";
		newRow.appendChild(td);
				
		lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);
		
		document.getElementById("total_debito").value=parseFloat(document.getElementById("total_debito").value) + debito;
		document.getElementById("total_credito").value=parseFloat(document.getElementById("total_credito").value) + credito;
	}
}



function removerFila_cuenta2(id,val_inicial,filaName,debito,credito)
{
	//RESTA EL VALOR DEL ITEM
	document.getElementById("total_debito").value=parseFloat(document.getElementById("total_debito").value) - debito;
	document.getElementById("total_credito").value=parseFloat(document.getElementById("total_credito").value) - credito;
	var num = document.getElementById(val_inicial);
	//REMUEVE EL NODO
	var fila = document.getElementById(id);
	fila.parentNode.removeChild(fila);
	//VALIDA CUAL ES EL ULTIMO ID;
	for(i = 0; i <= num.value; i++){
		var idFila = document.getElementById(filaName + i); 
		if (idFila != null) lastRow = i;
	}
	num.value = lastRow;
}