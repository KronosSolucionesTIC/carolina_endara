<?
function Imprime_fechas($dia,$mes,$ano,$forma)
	{
	if($forma==1)
    	{
    	if($mes=="01"){$mes = "Enero";}
		if($mes=="02"){$mes = "Febrero";}
		if($mes=="03"){$mes = "Marzo";}
		if($mes=="04"){$mes = "Abril";}
		if($mes=="05"){$mes = "Mayo";}
		if($mes=="06"){$mes = "Junio";}
		if($mes=="07"){$mes = "Julio";}
		if($mes=="08"){$mes = "Agosto";}
		if($mes=="09"){$mes = "Septiembre";}
		if($mes=="10"){$mes = "Octubre";}
		if($mes=="11"){$mes = "Noviembre";}
		if($mes=="12"){$mes = "Diciembre";}
		print $dia;
		print (" de ");
		print $mes;
		print (" de ");
		print $ano;
		}
	if($forma==2)    	
		{
		if($mes=="01"){$mes = "Ene.";}
		if($mes=="02"){$mes = "Feb.";}
		if($mes=="03"){$mes = "Mar.";}
		if($mes=="04"){$mes = "Abr.";}
		if($mes=="05"){$mes = "May.";}
		if($mes=="06"){$mes = "Jun.";}
		if($mes=="07"){$mes = "Jul.";}
		if($mes=="08"){$mes = "Ago.";}
		if($mes=="09"){$mes = "Sep.";}
		if($mes=="10"){$mes = "Oct.";}
		if($mes=="11"){$mes = "Nov.";}
		if($mes=="12"){$mes = "Dic.";}
		print $dia;
		print (" de ");
		print $mes;
		print (" de ");
		print $ano;		
		}
	}

function Imprime_meses($dia,$mes,$ano,$forma)
	{
	if($forma==1)
   		{
    	if($mes=="01"){$mes = "Enero";}
		if($mes=="02"){$mes = "Febrero";}
		if($mes=="03"){$mes = "Marzo";}
		if($mes=="04"){$mes = "Abril";}
		if($mes=="05"){$mes = "Mayo";}
		if($mes=="06"){$mes = "Junio";}
		if($mes=="07"){$mes = "Julio";}
		if($mes=="08"){$mes = "Agosto";}
		if($mes=="09"){$mes = "Septiembre";}
		if($mes=="10"){$mes = "Octubre";}
		if($mes=="11"){$mes = "Noviembre";}
		if($mes=="12"){$mes = "Diciembre";}
		print $mes;
		print (" de ");
		print $ano;
		}
	if($forma==2)    	
		{
		if($mes=="01"){$mes = "Ene.";}
		if($mes=="02"){$mes = "Feb.";}
		if($mes=="03"){$mes = "Mar.";}
		if($mes=="04"){$mes = "Abr.";}
		if($mes=="05"){$mes = "May.";}
		if($mes=="06"){$mes = "Jun.";}
		if($mes=="07"){$mes = "Jul.";}
		if($mes=="08"){$mes = "Ago.";}
		if($mes=="09"){$mes = "Sep.";}
		if($mes=="10"){$mes = "Oct.";}
		if($mes=="11"){$mes = "Nov.";}
		if($mes=="12"){$mes = "Dic.";}
		print $mes;
		print (" de ");
		print $ano;		
		}
	}
?>