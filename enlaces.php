<!-- Fernando Vera -->
<style>
    @font-face{
        src: url("fonts/CaviarDreams.ttf");
        font-family:"CaviarDreams";
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
        font-family: "Arial, Helvetica, sans-serif";
        width:300px ;
        height:40px;
        font-size: 1.5em;
        background-color:#ededed;
        border: 1px solid black;
        margin-left:6%;
        margin-top:.5%;
    }
    .container{
        border: 1px solid black;
        justify-content: space-around;
        margin-left:6%;
        margin-right:7%;
        margin-bottom: 4%;
    }
    footer {
        background-color:#FFDF61;
        position: fixed;
        font-size:.9em;
        padding-top:.5%;
        padding-bottom:.5%;
        text-align:center;
        left: 0;
        bottom: 0;
        width: 100%;
    }
    #box{
        background-color:rgb(216, 219, 220);
        padding:2% 1% 2% 1%;
        text-align: center;
        border: 1px solid black;
        font-size: 1.5rem;
        font-family:"CaviarDreams";
        font-weight: 900;
    }
    h1{
        color:black;
        font-size:3em;
    }
    input:focus {
        outline: 0;
    }

    input:hover{
        background-color: rgb(255, 255, 255);
    }
    #box:hover{
        background-color: rgb(255, 255, 255);
    }  
    a:visited{
        color:black;   
    }
    a{
        color:black;
    }
    a:hover{
        color:rgb(0,105,5);
    }
    .Pagina{
        width:1200px;
    }
    #volver{
        position:absolute;
        top:125px;
    }
</style>
<?php
ini_set("display_errors", 0); // EVITA QUE SALGA POR PANTALLA LOS ERRORES.
echo '<center><div class="Pagina"><div id="sup"><img src="logoGobiernoCanarias.jpg"></div>';
echo '<form id ="volver" action="index.php"><input type="submit" value="Volver"></form>'; // BOTON VOLVER
echo "<center><h1 id ='conexion'> Enlaces de interés</h1></center><br/>";
echo '<div class="container">';
if (file_exists('xmlConEnlaces.xml')) {
    $xml = simplexml_load_file('xmlConEnlaces.xml');
    $arrayXML = $xml->enlace;
    $tamaño = sizeOf($arrayXML);
    $i = -1;
    while ($i++ < $tamaño - 1) {
        echo "<a href='" . $xml->enlace[$i]->url . "'>";
        echo "<div id = 'box'>";
        echo $xml->enlace[$i]->nombre . "<br>";
        echo "</div></a>";
    }
} else {
    exit('No existen enlaces de interes');
}
echo '</div>';
echo "<footer>FERNANDO EZEQUIEL VERA 2ºDAW DSW</footer>";
?>