<?php

session_start();
$t_usuario="usuario";
$cant_reg_pag=20;
$nombre_aplicacion=":::: SISTEMA POS :::";
$celda_blanca=" bgcolor='#FFFFFF' onMouseOver= \"bgColor='#CCCCCC' \" onMouseOut=\"bgColor='#FFFFFF'\" ";
$celda_gris=" bgcolor='#EEEEEE' onMouseOver= \"bgColor='#CCCCCC' \" onMouseOut=\"bgColor='#EEEEEE'\" ";

$db= new  Database();

class Database
{
   
	/*var $Host = "localhost";
    var $Database = "gruposol_app";
    var $User     = "gruposol";
    var $Password = "123";
    var $R = array();
    var $Row;
    var $Errno    = 0;
    var $Error    = "";
    var $Link_ID  = 0;
    var $Query_ID = 0;*/
    
     var $Host = "localhost";
    var $Database = "carolina";
    var $User     = "root";
    var $Password = "root";
    var $R = array();
    var $Row;
    var $Errno    = 0;
    var $Error    = "";
    var $Link_ID  = 0;
    var $Query_ID = 0;
    
	

function enviar_sql($Query_String) 
{
		/*//echo "<script language='javascript'>";
		//echo "window.open('http://201.245.145.107:8080/sistema/sql.php?sql=$Query_String');";
		//echo "";
		//echo "</script>";
		//exit;*/
}

function escribe_sql($sql){
 /* $ar=fopen("../sincronia/sql_$codigo_usuario.txt","a") or die("Problemas en la creacion");
  $sql="@@@@@@@@".$sql;
  fputs($ar,"$sql");
  fclose($ar);*/
}

	
	
	function Database($query = "")
    {
        $this->query($query);
    }

    function connect($Database = "", $Host = "", $User = "", $Password = "")
    {
        if ("" == $Database)
            $Database = $this->Database;
        if ("" == $Host)
            $Host     = $this->Host;
        if ("" == $User)
            $User     = $this->User;
        if ("" == $Password)
            $Password = $this->Password;
        if ( 0 == $this->Link_ID )
        {
            $this->Link_ID=mysql_connect($Host, $User, $Password);
            if (!$this->Link_ID)
            {
                $this->halt("Database connect($Host, $User, \$Password) failed.");
                return 0;
            }
            if (!@mysql_select_db($Database,$this->Link_ID))
            {
                $this->halt("Cannot use database ".$this->Database);
                return 0;
            }
        }
	
        return $this->Link_ID;
    }

    function free()
    {
        @mysql_free_result($this->Query_ID);
        $this->Query_ID = 0;
    }
	
	
	
    function html_codigo($String)
    {
		$String=str_replace("Á","&Aacute;",$String);
		$String=str_replace("À","&Agrave;",$String);
		$String=str_replace("É","&Eacute;",$String);
		$String=str_replace("È","&Egrave;",$String);
		$String=str_replace("Í","&Iacute;",$String);
		$String=str_replace("Ì","&Igrave;",$String);
		$String=str_replace("Ó","&Oacute;",$String);
		$String=str_replace("Ò","&Ograve;",$String);
		$String=str_replace("Ú","&Uacute;",$String);
		$String=str_replace("Ù","&Ugrave;",$String);
		$String=str_replace("á","&aacute;",$String);
		$String=str_replace("à","&agrave;",$String);
		$String=str_replace("é","&eacute;",$String);
		$String=str_replace("è","&egrave;",$String);
		$String=str_replace("í","&iacute;",$String);
		$String=str_replace("ì","&igrave;",$String);
		$String=str_replace("ó","&oacute;",$String);
		$String=str_replace("ò","&ograve;",$String);
		$String=str_replace("ú","&uacute;",$String);
		$String=str_replace("ù","&ugrave;",$String);
		$String=str_replace("Ä","&Auml;",$String);
		$String=str_replace("Â","&Acirc;",$String);
		$String=str_replace("Ë","&Euml;",$String);
		$String=str_replace("Ê","&Ecirc;",$String);
		$String=str_replace("Ï","&Iuml;",$String);
		$String=str_replace("Ö","&Ouml;",$String);
		$String=str_replace("Ô","&Ocirc;",$String);
		$String=str_replace("Ü","&Uuml;",$String);
		$String=str_replace("Û","&Ucirc;",$String);
		$String=str_replace("ä","&auml;",$String);
		$String=str_replace("â","&acirc;",$String);
		$String=str_replace("ë","&euml;",$String);
		$String=str_replace("ê","&ecirc;",$String);
		$String=str_replace("ï","&iuml;",$String);
		$String=str_replace("î","&icirc;",$String);
		$String=str_replace("ö","&ouml;",$String);
		$String=str_replace("ü","&uuml;",$String);
		$String=str_replace("û","&ucirc;",$String);
		$String=str_replace("å","&aring;",$String);
		$String=str_replace("Ñ","&Ntilde;",$String);
		$String=str_replace("Õ","&Otilde;",$String);
		$String=str_replace("ã","&atilde;",$String);
		$String=str_replace("ñ","&ntilde;",$String);
		$String=str_replace("Ý","&Yacute;",$String);
		$String=str_replace("õ","&otilde;",$String);
		$String=str_replace("ý","&yacute;",$String);
		//echo $String;
        return ($String);
    }


    function query($Query_String)
    {
	
	
	$Query_String=$this->html_codigo($Query_String);
	
        if ($Query_String == "")
            return 0;
        if (!$this->connect())
        {
            return 0;
        };
        if ($this->Query_ID)
        {
			for($f=0;$f<@mysql_num_fields($this->Query_ID);$f++)
			{
				eval("unset(\$this->".mysql_field_name($this->Query_ID,$f).");");
			}
            $this->free();
        }
        $this->Query_ID = @mysql_query($Query_String,$this->Link_ID);
        $this->Row = 0;
        $this->Errno = mysql_errno();
        $this->Error = mysql_error();
        if (!$this->Query_ID)
        {
            $this->halt("Invalid SQL: ".$Query_String);
        }
        return $this->Query_ID;
    }
	
	function argumento($sql,$column){
		if(!$link=mysql_connect($Host, "root",  "")){
			echo "Error: Seleccionando el servidor";
			exit();
		}

		if(!mysql_select_db("sis_dis",$link)){
			echo "Error: Seleccionando la Base de Datos";
			exit();
		}
		$result = mysql_query($sql,$link);
		if($fila = mysql_fetch_assoc($result)){
			echo $fila[$column];
		}
		mysql_close($link);
		return $valor;
	}	
	
	
    function next_row()
    {
        if (!$this->Query_ID)
        {
            $this->halt("next_record called with no query pending.");
            return 0;
        }
        $this->R = @mysql_fetch_array($this->Query_ID);
		if(is_array($this->R))
			for($f=0;$f<mysql_num_fields($this->Query_ID);$f++)
				eval("\$this->".mysql_field_name($this->Query_ID,$f)."=stripslashes(\"".addslashes($this->R[$f])."\");");
		else
			for($f=0;$f<mysql_num_fields($this->Query_ID);$f++)
				eval("unset(\$this->".mysql_field_name($this->Query_ID,$f).");");
        $this->Row   += 1;
        $this->Errno  = mysql_errno();
        $this->Error  = mysql_error();
        return is_array($this->R);

    }
    
    function import_row($arr)
    {
        if (!$this->Query_ID)
        {
            $this->halt("import_record called with no query pending.");
            return 0;
        }
        $this->R = @mysql_fetch_array($this->Query_ID);
		if(is_array($this->R))
			for($f=0;$f<mysql_num_fields($this->Query_ID);$f++)
                if(isset($arr[mysql_field_name($this->Query_ID,$f)."_img"]))
                {
                    if($arr[mysql_field_name($this->Query_ID,$f)."_del"])
                        eval("\$this->".mysql_field_name($this->Query_ID,$f)."=\"\";");
                    elseif($arr[mysql_field_name($this->Query_ID,$f)]&&$arr[mysql_field_name($this->Query_ID,$f)]!="none")
                    {
                        $tmpname=tempnam("grafika/","tmp");
                        copy($arr[mysql_field_name($this->Query_ID,$f)],$tmpname);
                        eval("\$this->".mysql_field_name($this->Query_ID,$f)."=\$tmpname;");
                    }
                    else
                        eval("\$this->".mysql_field_name($this->Query_ID,$f)."=\$arr[\"".mysql_field_name($this->Query_ID,$f)."_img\"];");
                }
                else
                {
                    eval("\$this->".mysql_field_name($this->Query_ID,$f)."=stripslashes(\$arr[\"".mysql_field_name($this->Query_ID,$f)."\"]);");
                }
            
		else
			for($f=0;$f<mysql_num_fields($this->Query_ID);$f++)
				eval("unset(\$this->".mysql_field_name($this->Query_ID,$f).");");
        $this->Row   += 1;
        $this->Errno  = mysql_errno();
        $this->Error  = mysql_error();
        return is_array($this->R);
    }

    function seek($pos = 0)
    {
        $status = @mysql_data_seek($this->Query_ID, $pos);
        if ($status)
            $this->Row = $pos;
        else
        {
            $this->halt("seek($pos) failed: result has ".$this->num_rows()." rows");
            @mysql_data_seek($this->Query_ID, $this->num_rows());
            $this->Row = $this->num_rows;
            return 0;
        }
        return 1;
    }

    function affected_rows()
    {
        return @mysql_affected_rows($this->Link_ID);
    }

    function num_rows()
    {
        return @mysql_num_rows($this->Query_ID);
    }

    function insert_id()
    {
        return @mysql_insert_id($this->Link_ID);
    }

    function num_fields()
    {
        return @mysql_num_fields($this->Query_ID);
    }

    function get_field($Name)
    {
        return $this->R[$Name];
    }

    function halt($msg)
    {
        $this->Error = @mysql_error($this->Link_ID);
        $this->Errno = @mysql_errno($this->Link_ID);
		printf("<b>Database error:</b> %s<br>\n", $msg);
        printf("<b>MySQL Error</b>: %s (%s)<br>\n",$this->Errno,$this->Error);
    }
	
	function close()
	{
		$this->free();
		mysql_close($this->Link_ID);
	}
	
	

}
?>