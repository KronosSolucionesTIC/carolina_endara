<? //include("lib/database.php")?>
<script language="javascript">
var tstylesNames=["Individual Style","Individual Style","Individual Style","Individual Style",];
var tXPStylesNames=["Individual Style",];
//--- Common
var tlevelDX=20;
var texpanded=0;
var texpandItemClick=1;
var tcloseExpanded=1;
var tcloseExpandedXP=0;
var ttoggleMode=1;
var tnoWrap=1;
var titemTarget="interna";

var titemCursor="hand";
var statusString="link";
var tblankImage="menus/data.files/blank.gif";
var tpathPrefix_img="";
var tpathPrefix_link="";

//--- Dimensions
var tmenuWidth="auto";
var tmenuHeight="auto";

//--- Positioning
var tabsolute=0;
var tleft="2px";
var ttop="2px";

//--- Font
var tfontStyle="normal 14 pt Verdana";
var tfontColor=["#000000","#000000"];
var tfontDecoration=["none","underline"];
var tfontColorDisabled="#ACACAC";
var tpressedFontColor="#AA0000";

//--- Appearance
var tmenuBackColor="";
var tmenuBackImage="menus/data.files/blank.gif";
var tmenuBorderColor="#FFFFFF";
var tmenuBorderWidth=0;
var tmenuBorderStyle="solid";

//--- Item Appearance
var titemAlign="left";
var titemHeight=22;
var titemBackColor=["#FFF","#FFF"];
var titemBackImage=["menus/data.files/blank.gif","menus/data.files/blank.gif"];

//--- Icons & Buttons
var ticonWidth="auto";
var ticonHeight="auto";
var ticonAlign="left";
var texpandBtn=["menus/data.files/bullet_blue.png","menus/data.files/bullet_blue.png","menus/data.files/bullet_green.png"];
var texpandBtnW=9;
var texpandBtnH=9;
var texpandBtnAlign="left";

//--- Lines
var tpoints=0;
var tpointsImage="";
var tpointsVImage="";
var tpointsCImage="";

//--- Floatable Menu
var tfloatable=0;
var tfloatIterations=10;
var tfloatableX=1;
var tfloatableY=1;

//--- Movable Menu
var tmoveable=0;
var tmoveHeight=12;
var tmoveColor="transparent";
var tmoveImage="menus/data.files/movepic.gif";

//--- XP-Style
var tXPStyle=1;
var tXPIterations=10;
var tXPBorderWidth=1;
var tXPBorderColor="#FFFFFF";
var tXPTitleBackColor="#67678D"; 
var tXPTitleBackImg="menus/data.files/xptitle_s.gif";
var tXPTitleLeft="menus/data.files/xptitleleft_s.gif";
var tXPTitleLeftWidth=4;
var tXPIconWidth=25;
var tXPIconHeight=32;
var tXPExpandBtn=["menus/data.files/xpexpand1_s.gif","menus/data.files/xpcollapse1_s.gif","menus/data.files/xpcollapse1_s.gif"];
var tXPBtnWidth=25;
var tXPBtnHeight=23;
var tXPFilter=1;

//--- Dynamic Menu
var tdynamic=0;

//--- State Saving
var tsaveState=0;
var tsavePrefix="menu1";

var tstyles = [
    ["tfontStyle=bold 10pt Verdana","tfontColor=#FFFFFF,#E6E6E6","tfontDecoration=none,none"],
    ["tfontStyle=bold 9pt Verdana","tfontColor=#3F3D3D,#7E7C7C","tfontDecoration=none,none"],
    ["tfontDecoration=none,none"],
    ["tfontStyle=bold 9pt Verdana","tfontColor=#444444,#5555FF"],
];
var tXPStyles = [
    ["tXPTitleBackColor=#D9DAE2","tXPTitleBackImg=data.files/xptitle2_s.gif","tXPExpandBtn=data.files/xpexpand2_s.gif,data.files/xpexpand3_s.gif,data.files/xpcollapse2_s.gif,data.files/xpcollapse3_s.gif"],
];
<?
$usu = $_SESSION['global_2'];
$db= new  Database();
$sql="SELECT  cod_mod, nom_mod,icono_mod,icono2_mod, cod_int_per,nom_int,rut_int, cod_usu_per,con_per,edi_per, ins_per,eli_per ,concat(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(rut_int,'?consulta='),cod_usu_per),'&editar='),edi_per),'&insertar='),ins_per),'&eliminar='),eli_per),'&pagina=1')
	AS rutas,cod_per FROM  permisos INNER JOIN interfaz   ON permisos.cod_int_per=interfaz.cod_int INNER JOIN modulos ON interfaz.cod_mod_int=modulos.cod_mod
	WHERE permisos.cod_usu_per=$usu  AND con_per>0 ORDER BY modulos.cod_mod ,cod_per asc"; 
$db->query($sql); 
$aux=1;
$modulo=0;
?>
var tmenuItems = [
			<? while($db->next_row()) 
			{			
				if($modulo != $db->cod_mod) 
				{//IMPRIMIR PADRE
					echo '["|'.$db->nom_mod.'","", "'.$db->icono_mod.'", "'.$db->icono2_mod.'", "", "'.$db->nom_mod.'", "", "", "", ],';
					$modulo=$db->cod_mod;
				}
				//IMPRIMIR HIJO
		   			echo '  ["||'.$db->nom_int.'","'.$db->rutas.'", "menus/data.files/bullet_arrow_right16.png", "menus/data.files/bullet_arrow_right32.png", "", "Consultar '.$db->nom_int.'", "", "", "", ],';
		    } 
			$db->close()?>
	
];

dtree_init();

</script>