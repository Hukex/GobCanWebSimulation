<!-- Fernando Vera -->
<title>Numero de demandantes</title>
<style>
    .container{
        border: 1px solid black;
        display:flex;
        justify-content: space-around; 
        padding: 3% 0 8% 0;
        margin-left:1.2%;
        margin-right:1.2%;
        margin-bottom :.5%;
    }
    input{
        font-family: "Arial, Helvetica, sans-serif";
        width:300px ;
        height:40px;
        font-size: 1.5em;
        background-color:#ededed;
        border: 1px solid black;
        margin-left:6%;
        margin-top:.5%;
    }
    footer {
        background-color:#FFDF61;
        font-size:.9em;
        padding-top:.5%;
        padding-bottom:.5%;
        text-align:center;
        width: 98%;
    }
    #ko{
        animation-name: prueba;
        animation-duration: 2s;
        -webkit-animation-name: prueba;
        -webkit-animation-duration: 2s;
    }
    @keyframes prueba {
        from {width:0px;}
    }
    body {
        zoom: 75%;
        font-family: "Arial, Helvetica, sans-serif";
        background-image: url("bg-body.png");
        background-position: center top;
        background-repeat: repeat-y;
    }

    input:focus {
        outline: 0;
    }

    input:hover {
        background-color: rgb(255, 255, 255);
    }
    #sup{
        background-color:#9aa19a;
        width:98%;

    }
    .Pagina{
        width:1200px;
    }
    #volver{
        position:absolute;
        top:105px;
    }
</style>
<?php
ini_set("display_errors", 0); // EVITA QUE SALGA POR PANTALLA LOS ERRORES.
echo '<center><div class="Pagina"><div id="sup"><img src="logoGobiernoCanarias.jpg"></div>';
// $con = mysqli_connect('localhost', "id11143897_root", 12345, "id11143897_demandantes"); VERSION EN LA NUBE
$con = mysqli_connect('localhost', "root", "", "demandantes");
if ($con) {
    $con->set_charset("utf8");
    echo '<form id="volver" action="index.php"><input type="submit" value="Volver"></form>'; // BOTON VOLVER
    echo "<center><h1 id ='conexion'> Numero de demandantes</h1></center><br/>";
    // Aqui realizaremos nuestras operaciones de consulta a la base de datos

    $consultaNombreLocalidad = "SELECT Localidad FROM localidades";
    $query = mysqli_query($con, $consultaNombreLocalidad);
    if ($query->num_rows > 0) {
        $varToColors = 1;
        echo '<div class="container"><table><caption><h2>Por Localidad</h2></caption>';
        while ($row = $query->fetch_assoc()) {
            $localidad = $row['Localidad'];
            $consultaNumDemandantePorLocalidad = 'SELECT COUNT(*) FROM `demandantes` INNER JOIN ha_trabajado on ha_trabajado.cod_demandante=demandantes.Cod_demandante INNER JOIN empresas on empresas.Cod_Empresa=ha_trabajado.Cod_empresa INNER JOIN localidades on localidades.cod_localidad=empresas.Cod_Localidad WHERE Localidad="' . $localidad . '";';
            $query2 = mysqli_query($con, $consultaNumDemandantePorLocalidad);
            $numDemandantePorLocalidad = $query2->fetch_row();
            if ($varToColors++ % 2 == 0) {
                echo "<tr><td>" . $localidad . ": </td><td><div id='ko' style = 'font-size:1.5em; text-align:center ; border: 1px solid black; height:30px; background-color: rgba(" . rand(52, 55) . "," . rand(106, 109) . "," . rand(124, 127) . ") ; width:" . $numDemandantePorLocalidad[0] * 2 . "px'>" . $numDemandantePorLocalidad[0] . "</div></td></tr>";
            } else {
                echo "<tr><td>" . $localidad . ": </td><td><div id='ko' style = 'font-size:1.5em; text-align:center ; border: 1px solid black; height:30px; background-color: rgba(200, 209, 201); width:" . $numDemandantePorLocalidad[0] * 2 . "px'>" . $numDemandantePorLocalidad[0] . "</div></td></tr>";
            }
        }
    }
    ////////////////////////////// PARTE 2
    $consultaNivel = "SELECT Nivel FROM estudios";
    $query3 = mysqli_query($con, $consultaNivel);
    if ($query3->num_rows > 0) {
        $varToColors = 1;
        echo '</table><table><caption><h2>Por Nivel de Estudios</h2></caption>';
        while ($row = $query3->fetch_assoc()) {
            $nivel = $row["Nivel"];
            $consultaNumNivel = 'SELECT COUNT(*) FROM `demandantes` INNER JOIN estudios on estudios.Cod_Nivel=demandantes.Nivel_estudios WHERE Nivel = "' . $nivel . '";';
            $query4 = mysqli_query($con, $consultaNumNivel);
            $numNivel = $query4->fetch_row();
            if ($varToColors++ % 2 == 0) {
                echo "<tr><td>" . $nivel . ": </td><td><div id= 'ko' style = 'font-size:1.5em; text-align:center ; border: 1px solid black; height:30px; background-color: rgba(44,97,118); width:" . $numNivel[0] * 2 . "px'>" . $numNivel[0] . "</div></td></tr>";
            } else {
                echo "<tr><td>" . $nivel . ": </td><td><div id='ko' style = 'font-size:1.5em; text-align:center ; border: 1px solid black; height:30px; background-color: rgba(200, 209, 201) ; width:" . $numNivel[0] * 2 . "px'>" . $numNivel[0] . "</div></td></tr>";
            }
        }
    }
    echo '</table></div><footer>FERNANDO EZEQUIEL VERA 2ºDAW DSW</footer>';
} else {
    echo "<center><h1>Error al conectar con la base de datos</h1></center>";
}
?>
