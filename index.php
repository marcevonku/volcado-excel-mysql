<?php
/* ***************************** */
/* ****** Rutinas Comunes ****** */
/* ***************************** */


include("include/funciones.php");


/* ******************************************* */
/* ****** Arma las opciones del Men ****** */
/* ******************************************* */
function Armar()
{

    global $tabla, $usuario, $rol_id, $mysql_link;

    $i = 0;
    $rol_id = $_SESSION['rol_id'];
    $sql = "select pri_programa, pri_desc from privilegios as a, priv_rol as b where a.pri_id = b.pri_id and b.rol_id= $rol_id and b.valor=1 order by a.pri_id";
    $Result = mysqli_query($mysql_link, $sql);
    while ($row = mysqli_fetch_row($Result)) {
        $tabla[$i]["href"] = $row[0];
        $tabla[$i]["text"] = $row[1];
        $i++;
    }
    mysqli_free_result($Result);
}

/* ******************************************* */
/* ****** Muestra las opciones del Men ****** */
/* ******************************************* */
function Mostrar()
{

    global $mensajes, $confirmar, $tabla, $usuario, $rol_id;


    $Titulo = "Men&uacute; Principal";
    include "include/arriba.inc";

    echo "    <br>\n";
    echo "    <br>\n";
    echo "    <center><table width='40%' class='menu'>\n";
    for ($i = 0; $i < count($tabla); $i++) {
        echo "        <tr>\n";
        echo "            <td width='50%' class='menu'>\n";
        echo                 "<img src='images/menu.jpg' valign='middle' border=0><a href='" . $tabla[$i]["href"] . "'>\n";
        echo                      $tabla[$i]["text"] . "\n";
        echo "                </a>\n";
        echo "            </td>\n";
        echo "        </tr>\n";
    }
    echo "    </table></center>\n";
    echo "    <br>\n";
    if ($mensajes) {
        Mostrar_Error($mensajes);
    }

    echo "</body>\n";
    echo "</html>\n";
    return true;
}

/* *********************** */
/* ******  M a i n  ****** */
/* *********************** */

$mensajes = "";

//echo $_SESSION['usuario'];
$usuario = $_SESSION['usuario'];
$password = $_SESSION['password'];



if (!Conectar()) {
    echo $mensaje;
    exit;
}
$_SESSION['usuario'] = $usuario;
$_SESSION['password'] = $password;
if (!Seguridad()) {
    header("Location:index.php");
    exit;
}

Armar();
Mostrar();
