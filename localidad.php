<!-- Fernando Vera -->
<meta charset="UTF-8">
<title>Nº demandantes por empleo</title>
<style>
    select{
        font-family:"CaviarDreams";
        background-color: #ededed;
        width:100%;
        font-size:2em;
    }
    select:focus{
        outline:0;
    }
    .container{
        border: 1px solid black;         
        padding-bottom: 5%;
        margin-bottom: .5%;
        width:98%;
    }
    .container > table{
        padding-left: 8%;
    }
    input{
        font-family: "Arial, Helvetica, sans-serif";
        width:300px;
        height:40px;
        font-size: 1.5em;
        background-color:#ededed;  
        border: 1px solid black;
        margin-left:4%;
        margin-top:.5%;


    }
    footer {
        background-color:#FFDF61;
        font-size:.9em;
        padding-top:.5%;
        padding-bottom:.5%;
        text-align:center;
        width:98%;
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
</style><body>
    <?php
    $ele = filter_input(INPUT_POST, 'ele', FILTER_SANITIZE_STRING);
    $errorConBaseDeDatos = "<center><h1>Existe un problema con la base de datos, por favor intentelo mas tarde.</h1></center>";
    echo '<center><div class="Pagina"><div id="sup"><img src="logoGobiernoCanarias.jpg"></div>';
    ini_set("display_errors", 0); // EVITA QUE SALGA POR PANTALLA LOS ERRORES.
// $con = mysqli_connect('localhost', "id11143897_root", 12345, "id11143897_demandantes"); VERSION EN LA NUBE
    $con = mysqli_connect('localhost', "root", "", "demandantes");
    if ($con) {
        $con->set_charset("utf8"); // PARA LOS CARACTERES ESPECIALES (TILDEEEEEEEES)
        echo '<form id="volver" action="index.php"><input type="submit" value="Volver"></form>'; // BOTON VOLVER
        echo "<h1 id ='conexion'> Numero de demandantes por empleo</h1><br/>";
// Aqui realizaremos nuestras operaciones de consulta a la base de datos
        $consultaNombreEmpleo = "SELECT Nombre_empleo FROM empleos";
        $query = mysqli_query($con, $consultaNombreEmpleo);
        if ($query->num_rows > 0) {
            $varToColors = 1;
            $consultaNombreLocalidad = "SELECT Localidad FROM localidades";
            $query2 = mysqli_query($con, $consultaNombreLocalidad);
            echo '<div class="container"><form method="POST"><select name="ele"><option>Lista de Localidades</option>';
            if ($query2->num_rows > 0) {
                $i = 0;
                $arrayConNombres = array($query2->num_rows); // Tamanho array
                $ko = 0;
                while ($row = $query2->fetch_assoc()) {
                    $localidad = $row['Localidad'];
                    $arrayConNombres[$i++] = $localidad;
                    echo "<option value ='" . $localidad . "'>" . $localidad . "</option>";
                }
                if (!isset($ele)) {
                    $ele = $arrayConNombres[0]; // PARA QUE AL INICIO SALGA POR PANTALLA LA PRIMERA LOCALIDAD
                }
                echo '</select></form><table><caption><h2>' . $ele . '</h2></caption>';
                while ($row = $query->fetch_assoc()) {
                    $empleo = ($row["Nombre_empleo"]);
                    $consultaNumEmpPorLocalidad = 'select COUNT(*) from demandantes inner join ha_trabajado on ha_trabajado.cod_demandante = demandantes.Cod_demandante inner join empleos on empleos.Cod_Empleo = ha_trabajado.cod_empleo inner join empresas on ha_trabajado.Cod_empresa = empresas.Cod_Empresa inner join localidades on localidades.cod_localidad = empresas.Cod_Localidad where localidad ="' . $arrayConNombres[array_search($ele, $arrayConNombres)] . '" and Nombre_empleo="' . $empleo . '";';
                    $query3 = mysqli_query($con, $consultaNumEmpPorLocalidad);
                    $numEmpPorLocalidad = $query3->fetch_row();
                    if ($varToColors++ % 2 == 0) {
                        echo "<tr><td>" . $empleo . ": </td><td><div id='ko' style = 'font-size:1.5em;text-align:center;border: 1px solid black;height:30px;background-color: rgba(" . rand(52, 55) . ", " . rand(106, 109) . ", " . rand(124, 127) . ");width:" . $numEmpPorLocalidad[0] . "00px'>" . $numEmpPorLocalidad[0] . "</div></td></tr>";
                    } else {
                        echo "<tr><td>" . $empleo . ": </td><td><div id='ko' style = 'font-size:1.5em;text-align:center;border: 1px solid black;height:30px;background-color: rgba(200, 209, 201);width:" . $numEmpPorLocalidad[0] . "00px'>" . $numEmpPorLocalidad[0] . "</div></td></tr>";
                    }
                }
            } else {
                echo $errorConBaseDeDatos;
            }
        } else {
            echo $errorConBaseDeDatos;
        }
        echo '</table></div><footer>FERNANDO EZEQUIEL VERA 2ºDAW DSW</footer></div>';
    } else {
        echo $errorConBaseDeDatos;
    }
    ?>
    <!-- Por hacer la web mas moderna, no aporta nada en php , solo hago que select haga lo de submit-->
    <script src="jquery-3.4.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        $('select').on('change', function ()
        {
            $(this).closest('form').submit();
        });
    </script>
</body>

