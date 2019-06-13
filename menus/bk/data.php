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
//var titemTarget="_blank";
var titemTarget="interna";


var titemCursor="pointer";
var statusString="link";
var tblankImage="menus/data.files/blank.gif";
var tpathPrefix_img="";
var tpathPrefix_link="";

//--- Dimensions
var tmenuWidth="190px";
var tmenuHeight="auto";

//--- Positioning
var tabsolute=0;
var tleft="2px";
var ttop="2px";

//--- Font
var tfontStyle="normal 8pt Tahoma";
var tfontColor=["#3F3D3D","#7E7C7C"];
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
var titemBackColor=["#D1D8DE","#D1D8DE"];
var titemBackImage=["menus/data.files/blank.gif","menus/data.files/blank.gif"];

//--- Icons & Buttons
var ticonWidth=21;
var ticonHeight=15;
var ticonAlign="left";
var texpandBtn=["menus/data.files/expandbtn2.gif","menus/data.files/expandbtn2.gif","menus/data.files/collapsebtn2.gif"];
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
var tXPTitleBackColor="#FF823B"; 
var tXPTitleBackImg="menus/data.files/xptitle_s.gif";
var tXPTitleLeft="menus/data.files/xptitleleft_s.gif";
var tXPTitleLeftWidth=4;
var tXPIconWidth=25;
var tXPIconHeight=32;
var tXPExpandBtn=["menus/data.files/xpexpand1_s.gif","menus/data.files/xpexpand1_s.gif","menus/data.files/xpcollapse1_s.gif","menus/data.files/xpcollapse1_s.gif"];
var tXPBtnWidth=25;
var tXPBtnHeight=23;
var tXPFilter=1;

//--- Dynamic Menu
var tdynamic=0;

//--- State Saving
var tsaveState=0;
var tsavePrefix="menu1";

var tstyles = [
    ["tfontStyle=bold 7pt Tahoma","tfontColor=#FFFFFF,#E6E6E6","tfontDecoration=none,none"],
    ["tfontStyle=bold 7pt Tahoma","tfontColor=#3F3D3D,#7E7C7C","tfontDecoration=none,none"],
    ["tfontDecoration=none,none"],
    ["tfontStyle=bold 7pt Tahoma","tfontColor=#444444,#5555FF"],
];
var tXPStyles = [
    ["tXPTitleBackColor=#D9DAE2","tXPTitleBackImg=data.files/xptitle2_s.gif","tXPExpandBtn=data.files/xpexpand2_s.gif,data.files/xpexpand3_s.gif,data.files/xpcollapse2_s.gif,data.files/xpcollapse3_s.gif"],
];

<?
$db= new  Database();
$sql="SELECT  cod_mod, nom_mod, cod_int_per,nom_int,rut_int, cod_usu_per,con_per,edi_per, ins_per,eli_per ,CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(rut_int,'?consulta='),cod_usu_per),'&editar='),edi_per),'?insertar='),ins_per),'?eliminar='),eli_per)
	AS rutas FROM  permisos INNER JOIN interfaz   ON permisos.cod_int_per=interfaz.cod_int INNER JOIN modulos ON interfaz.cod_mod_int=modulos.cod_mod
	WHERE permisos.cod_usu_per=1  ORDER BY modulos.cod_mod , interfaz.cod_int "; 
$db->query($sql); 
?>
var tmenuItems = [

    ["Menu del Sistema","", "menus/data.files/xpicon1_s.gif", "", "", "XP Title Tip", "", "0", "", ],
        ["|Inicio","testlink.htm", "menus/data.files/icon1_s.gif", "menus/data.files/icon1_so.gif", "", "Home Page Tip", "", "", "", ],
        ["|Administracion","", "menus/data.files/icon2_s.gif", "menus/data.files/icon2_so.gif", "", "Product Info Tip", "", "", "", ],
            ["||Adm. de Invenario","", "", "", "", "", "", "", "", ],
			<? while($db->next_row()) {			
   echo '  ["|||Unidades","interna.php", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "", "", "", "", ],';
    } ?>
                ["|||Unidades","interna.php", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Almacenes","", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Moviles","", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Tipo de Referncia","", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "", "", "", "", ],
            
			["||Adm. de Operacion","", "", "", "", "", "", "", "", ],
			
                ["|||Empleados","", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Carga de Archivo","", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "", "", "", "", ],
				
            ["||Adm. de Seguridad","", "", "", "", "", "", "", "", ],
			
                ["|||Usuarios","con_usuario.php", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Modulos","testlink.htm", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Permisos","testlink.htm", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Informe Auditoria","testlink.htm", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "", "", "", "", ],
				
        ["|Inventario","", "menus/data.files/icon3_s.gif", "menus/data.files/icon3_so.gif", "", "Samples Tip", "", "", "", ],
            ["||Proveedores","testlink.htm", "menus/data.files/iconarrs.gif", "", "", "", "", "", "", ],
            ["||Pedidos","testlink.htm", "menus/data.files/iconarrs.gif", "", "", "", "", "", "", ],
            ["||Referencias","testlink.htm", "menus/data.files/iconarrs.gif", "", "", "", "", "", "", ],
            ["||Movimientos","testlink.htm", "menus/data.files/iconarrs.gif", "", "", "", "", "", "", ],
        ["|Operacion","testlink.htm", "menus/data.files/icon4_s.gif", "menus/data.files/icon4_so.gif", "", "Purchase Tip", "", "", "", ],
        ["|Operaciones Externas","", "menus/data.files/icon5_s.gif", "menus/data.files/icon5_so.gif", "", "Support Tip", "", "", "", ],
            ["||Write Us","mailto:dhtml@dhtml-menu.com", "menus/data.files/iconarrs.gif", "", "", "", "", "", "", ],
];

dtree_init();
</script>