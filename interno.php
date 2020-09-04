<!-- Fernando Vera -->
<link rel="stylesheet" href="css/all.css">
<title>Pagina Interna</title>
<style>
    select{
        background-color: #ededed;
        margin-top:2%;
        margin-bottom:-45px;
    }
    .ele{
        font-size:1.6em;
        width:30%;
        margin-right:810px;
    }
    select:focus{
        outline:0;
    }
    #sup{
        background-color:#9aa19a;
        width:98%;
    }
    body {
        zoom: 75%;
        font-family: "Arial, Helvetica, sans-serif";
        background-image: url("bg-body.png");
        background-position: center top;
        background-repeat: repeat-y;
    }
    input{
        font-family: "Arial";
        width:300px ;
        height:40px;
        font-size: 1.5em;
        background-color:#ededed;
        border: 1px solid #c0bfbf;
    }
    input:focus {
        outline: 0;
    }
    input:hover {
        background-color: rgb(255, 255, 255);
    }
    .Pagina{
        width:1200px;
    }
    #volver{
        position:absolute;
        top:125px;
        margin-left:1%;
    }
    #volverd{
        position:relative;
        margin-left: 0%;
    }
    #contenedor{
        margin-top:13%;
        margin-bottom:13%;
        border: 1px double #c0bfbf;
        width: 45%;
        background-color:#ededed;
    }
    .duser{
        margin:5%;
        display:flex;
    }
    #user{
        width:90%;
        padding-left:8px;
        background-color:white;
    }
    #us, #ps{
        background-color:#a1a1a1;
        width:40px;
        border: 1px solid black;
        border-radius:20%;
        margin-right: -5px;
        z-index: 100;
    }
    #us>i,#ps>i{
        margin-top:25%;
    }
    .dpasswd{
        margin:5%;
        display:flex;
    }
    #passwd{
        padding-left:8px;
        width:90%;
        background-color:white;

    }
    #user:focus,#passwd:focus{
        border:2px solid #66afe9;

    }
    #enter{
        width:88%;
        margin-left:0;
        margin-top:5%;
        background-color:#a1a1a1;
        border-color: black;
    }
    #enter:hover{
        background-color:#9d9a9a8c;
    }
    footer {
        font-weight:400;
        background-color:#FFDF61;
        font-size:.9em;
        padding-top:.5%;
        padding-bottom:.5%;
        text-align:center;
        width: 98%;
    }
    table{
        background-color:#b1adad;
        border-radius:10px;
    }
    .nowrap{
        white-space:nowrap;
    }
    td{
        padding-top:1%;
        padding-bottom: 1%;
        padding-left:1%;   
        border-radius:4px;
        width:10%;
    }
    tbody{
        background-color:#ededed;
    }
    tbody>tr:hover{
        background-color:white;
    }
    .order{
        margin-left:120px;
        margin-top:.1%;
        padding:.2%;
        font-size:1em;
    }
    .dOrder{
        width:30%;
        position:relative;
        left:455px;
        top:10px;
        margin-bottom:-20px;
    }
    .errorLogin{
        color:red;
        font-size:1.2em;
        position:relative;
        top:-5px;
        padding:2px;
        font-style:normal;
    }
    .ti{
        color:red;
        font-size:1.2em;
    }
</style>
<?php
$segundos = 20; // Segundos que queramos para el bloqueo temporal
ini_set("display_errors", 0); // EVITA QUE SALGA POR PANTALLA LOS ERRORES.
session_start();
// Si no existe el contador se inicializa a 0 , de esta forma al recargarse la pagina permitimos que mantenga su valor, se usa para bloquear temporalmente si vale 3 el contador.
if (!isset($_SESSION['contador'])) {
    $_SESSION['contador'] = 0;
}
echo '<center><div class="Pagina"><div id="sup"><img src="logoGobiernoCanarias.jpg"></div>';
$ele = filter_input(INPUT_POST, 'ele', FILTER_SANITIZE_STRING);
$ordenar = filter_input(INPUT_POST, 'ordenar', FILTER_SANITIZE_STRING);
$user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
$passwd = filter_input(INPUT_POST, 'passwd', FILTER_SANITIZE_STRING);
// POR SEGURIDAD SE FILTRA LA ENTRADA DATOS
//Se comprueba inicialmente si la contraseña y el usuario son correctos se crea el formulario, que luego para poder entrar y modificar ese formulario se usa $ele y $ordenar.
if (isset($user) && ($user == "Admin") && isset($passwd) && ($passwd == "Admin") || isset($ele) || isset($ordenar)) {
    $_SESSION['contador'] = 0; // Al loguearse se resetean los intentos.
    $con = mysqli_connect('localhost', "root", "", "demandantes");
    if ($con) {
        echo "<h1>BIENVENIDO AL SISTEMA INTERNO DE EMPLEADOS</h1>";
        echo '<form id="volverD" action="interno.php"><input type="submit" value="Cerrar Sesión"></form>'; // BOTON CERRRAR
        $con->set_charset("utf8"); // Se codifica la conexion con caracteres UTF-8
        $consultaNombreEmpleo = "SELECT Nombre_empleo FROM empleos";
        $query = mysqli_query($con, $consultaNombreEmpleo);
        $primerEmpleo = "";
        // Se crea el select(menu) con los empleos que existan en la BD.
        if ($query->num_rows > 0) {
            $primerNombre = true;
            echo '<form method="POST"><select class ="ele" name="ele"><option>Selecciona un empleo</option>';
            while ($row = $query->fetch_assoc()) {
                if ($primerNombre) {
                    $primerEmpleo = $row['Nombre_empleo'];
                    $primerNombre = false;
                }
                $empleo = ($row["Nombre_empleo"]);
                echo "<option value ='" . $empleo . "'>" . $empleo . "</option>";
            }
            echo "</select></form>";
        }
        // Ordena por defecto por nombre
        if (!isset($ordenar)) {
            $ordenar = "Nombre";
        }

        if (!isset($ele) && isset($_SESSION['eleSave'])) {
            $ele = $_SESSION['eleSave']; // Se guarda el empleo anterior para que al ordenar no se resetee al primer empleo.
        } else if (!isset($ele)) {
            $ele = $primerEmpleo; // Por defecto al cargar la pagina se usa esto.
        }
        if (isset($ele)) {
            $_SESSION['eleSave'] = $ele;
            echo "<form method='POST' class='dOrder'><select name='ordenar' class='order'><option>Ordenar por</option><option value='Nombre'>Nombre</option><option value='Apellidos'>Apellidos</option><option value='Localidad'>Localidad</option><option value='Pais'>Nacionalidad</option><option value='fecha_inicio'>Fecha de Inicio</option><option value='fecha_fin'>Fecha de Fin</option><option value='Nombre_empresa'>Nombre Empresa</option><option value='Nivel'>Nivel de Estudios</option></select></form>"; //El menu de ordenar

            $consultaDatos = 'select Nombre,Apellidos,Localidad,Pais,fecha_inicio,fecha_fin,Nombre_empresa,Nivel from demandantes inner join ha_trabajado on ha_trabajado.cod_demandante = demandantes.Cod_demandante inner join empleos on empleos.Cod_Empleo = ha_trabajado.cod_empleo inner join empresas on ha_trabajado.Cod_empresa = empresas.Cod_Empresa inner join localidades on localidades.cod_localidad = empresas.Cod_Localidad inner join estudios on estudios.Cod_Nivel=demandantes.Nivel_estudios inner join nacionalidades on nacionalidades.Cod_nacionalidad=demandantes.Nacionalidad where Nombre_empleo="' . $ele . '" order by ' . $ordenar . ';';
            $query2 = mysqli_query($con, $consultaDatos);
            //Crea la tabla y la muestra por pantalla
            if ($query2->num_rows > 0) {
                switch ($ordenar) {
                    case "Nombre": echo "<div style='padding-bottom:1%;width:98%;'><table><caption><h2>" . $ele . "</h2></caption><thead><tr><th style='background-color:white;border:1px solid #b1adad;border-radius:50%;'>Nombre</th><th>Apellidos</th><th>Localidad</th><th>Nacionalidad</th><th>Fecha de Inicio</th><th>Fecha de Fin</th><th>Nombre Empresa</th><th>Nivel de estudios</th></tr></thead><tbody>";
                        break;
                    case "Apellidos": echo "<div style='padding-bottom:1%;width:98%;'><table><caption><h2>" . $ele . "</h2></caption><thead><tr><th>Nombre</th><th style='background-color:white;border:1px solid #b1adad;border-radius:50%;'>Apellidos</th><th>Localidad</th><th>Nacionalidad</th><th>Fecha de Inicio</th><th>Fecha de Fin</th><th>Nombre Empresa</th><th>Nivel de estudios</th></tr></thead><tbody>";
                        break;
                    case "Localidad": echo "<div style='padding-bottom:1%;width:98%;'><table><caption><h2>" . $ele . "</h2></caption><thead><tr><th>Nombre</th><th>Apellidos</th><th style='background-color:white;border:1px solid #b1adad;border-radius:50%;'>Localidad</th><th>Nacionalidad</th><th>Fecha de Inicio</th><th>Fecha de Fin</th><th>Nombre Empresa</th><th>Nivel de estudios</th></tr></thead><tbody>";
                        break;
                    case "Pais": echo "<div style='padding-bottom:1%;width:98%;'><table><caption><h2>" . $ele . "</h2></caption><thead><tr><th>Nombre</th><th>Apellidos</th><th>Localidad</th><th style='background-color:white;border:1px solid #b1adad;border-radius:50%;'>Nacionalidad</th><th>Fecha de Inicio</th><th>Fecha de Fin</th><th>Nombre Empresa</th><th>Nivel de estudios</th></tr></thead><tbody>";
                        break;
                    case "fecha_inicio": echo "<div style='padding-bottom:1%;width:98%;'><table><caption><h2>" . $ele . "</h2></caption><thead><tr><th>Nombre</th><th>Apellidos</th><th>Localidad</th><th>Nacionalidad</th><th style='background-color:white;border:1px solid #b1adad;border-radius:50%;'>Fecha de Inicio</th><th>Fecha de Fin</th><th>Nombre Empresa</th><th>Nivel de estudios</th></tr></thead><tbody>";
                        break;
                    case "fecha_fin": echo "<div style='padding-bottom:1%;width:98%;'><table><caption><h2>" . $ele . "</h2></caption><thead><tr><th>Nombre</th><th>Apellidos</th><th>Localidad</th><th>Nacionalidad</th><th>Fecha de Inicio</th><th style='background-color:white;border:1px solid #b1adad;border-radius:50%;'>Fecha de Fin</th><th>Nombre Empresa</th><th>Nivel de estudios</th></tr></thead><tbody>";
                        break;
                    case "Nombre_empresa": echo "<div style='padding-bottom:1%;width:98%;'><table><caption><h2>" . $ele . "</h2></caption><thead><tr><th>Nombre</th><th>Apellidos</th><th>Localidad</th><th>Nacionalidad</th><th>Fecha de Inicio</th><th>Fecha de Fin</th><th style='background-color:white;border:1px solid #b1adad;border-radius:50%;'>Nombre Empresa</th><th>Nivel de estudios</th></tr></thead><tbody>";
                        break;
                    case "Nivel": echo "<div style='padding-bottom:1%;width:98%;'><table><caption><h2>" . $ele . "</h2></caption><thead><tr><th>Nombre</th><th>Apellidos</th><th>Localidad</th><th>Nacionalidad</th><th>Fecha de Inicio</th><th>Fecha de Fin</th><th>Nombre Empresa</th><th style='background-color:white;border:1px solid #b1adad;border-radius:50%;'>Nivel de estudios</th></tr></thead><tbody>";
                        break;
                } //SIMPLEMENTE LO USO PORQUE NO PUEDO USAR JAVASCRIPT

                while ($row = $query2->fetch_assoc()) {
                    echo "<tr><td>" . $row['Nombre'] . "</td><td>" . $row['Apellidos'] . "</td><td>" . $row['Localidad'] . "</td><td>" . $row['Pais'] . "</td><td class='nowrap'>" . $row['fecha_inicio'] . "</td><td class='nowrap'>" . $row['fecha_fin'] . "</td><td>" . $row['Nombre_empresa'] . "</td><td>" . $row['Nivel'] . "</td></tr>";
                }
                echo "</tbody></table></div>";
            }
        }
    } else {
        echo "<h1>Error con la base de datos</h1>";
    }
} elseif ((isset($user) && ($user != "Admin") || isset($passwd) && ($passwd != "87654321_")) || isset($_SESSION['contador']) && ($_SESSION['contador'] >= 3)) {
    // Entra aqui cuando se falla el usuario/contraseña o cuando esta bloqueado temporalmente
    $_SESSION['contador'] ++;
    echo '<form id="volver" action="index.php"><input type="submit" value="Volver"></form>'; // BOTON VOLVER
    echo '<div id="contenedor" ><form action="interno.php" method="POST">
        <h4>Ingrese los datos para acceder</h4>';
    if ($_SESSION['contador'] < 3) {
        // Nos imprime esto porque aun tiene mas intentos para loguearse.
        echo ' <div class ="duser"><span id="us"><i class="fas fa-user"></i></span><input id= "user" name ="user" pattern="^[A-Za-z]*[0-9]*" maxlength=20 placeholder=" Usuario" type="text"></div>
        <div class ="dpasswd"><span id="ps"><i class="fas fa-lock"></i></span><input id="passwd" name="passwd" type="password" maxlength=20 placeholder=" Contraseña" ></div><input name = "enter" id = "enter" type = "submit" value = "Acceder"></form><span class = "errorLogin"> Introduzca un usuario y una contraseña correcta</span></div>';
    } else {
        // En caso de no tenerlos ya pasaria a bloquearse el acceso temporalmente
        if (!isset($_SESSION['Tiempo'])) {
            $_SESSION['Tiempo'] = time();  // Si no existe la session que almacenara el tiempo en el cual se realiza el bloqueo , pues se crea.
        }

        $ti = abs(abs(($_SESSION['Tiempo']) - time()) - $segundos);
        //Se comparan el tiempo almacenado con el tiempo actual, para que el contador vaya del numero de segundos especificado a 0

        if (time() >= ($_SESSION['Tiempo'] + $segundos)) {
            //Entra aqui cuando el tiempo actual ya es mayor que el tiempo almacenado + los segundos de bloqueo que hubiesemos elegido.
            $_SESSION['contador'] = 0;
            $_SESSION['Tiempo'] = null; // Consigo que isset detecte la seccion como que no existe.
        }
        header("Refresh:1"); // Al no usar javascript la manera de actualizar el contador de segundos es refrescando la pagina constantemente, en este caso cada 1 segundo.(NO ES OPTIMO)
        echo ' <div class ="duser"><span id="us"><i class="fas fa-user"></i></span><input id= "user" name ="user" pattern="^[A-Za-z]*[0-9]*" maxlength=20 placeholder=" Usuario" readonly type="text"></div>
        <div class ="dpasswd"><span id="ps"><i class="fas fa-lock"></i></span><input id="passwd" name="passwd" type="password" maxlength=20 placeholder=" Contraseña" readonly></div><p>BLOQUEADO ESPERE <span class="ti">' . $ti . '</span> SEGUNDOS</p></div>';
    }
} else {
    // ESTE CODIGO SE EJECUTA POR DEFECTO YA QUE ES LA VENTANA DE LOGUEO
    $_SESSION['eleSave'] = null; // Borrar el trabajo anterior,al cerrar sesion
    echo '<form id = "volver" action = "index.php"><input type = "submit" value = "Volver"></form>'; // BOTON VOLVER
    echo '<div id = "contenedor" ><form action = "interno.php" method = "POST">
<h4>Ingrese los datos para acceder</h4>
<div class = "duser"><span id = "us"><i class = "fas fa-user"></i></span><input id = "user" name = "user" pattern = "^[A-Za-z]*[0-9]*" maxlength = 20 placeholder = " Usuario" type = "text"></div>
<div class = "dpasswd"><span id = "ps"><i class = "fas fa-lock"></i></span><input id = "passwd" name = "passwd" type = "password" maxlength = 20 placeholder = " Contraseña" ></div><input name = "enter" id = "enter" type = "submit" value = "Acceder"></form></div>';
}
?>
<footer>FERNANDO EZEQUIEL VERA 2ºDAW DSW</footer>

<!-- Por hacer la web mas moderna, no aporta nada en php , solo hago que select haga lo de submit-->
<script src="jquery-3.4.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
    $('select').on('change', function ()
    {
        $(this).closest('form').submit();
    });
</script>