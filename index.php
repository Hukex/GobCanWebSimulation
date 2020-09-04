<!-- Fernando Vera -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Demandantes</title>
        <style>
            #menu{
                display:flex;
                justify-content: center;
                background-color: transparent;
            }
            form{
                padding:.5%;
            }
            input{
                font-family: "Arial, Helvetica, sans-serif";
                box-shadow: 3px 2px;
                width:280px;
                height:80px;
                color:#2f2f2f;
                font-weight: 900;
                font-size:1.5em;
                background-color:#ededed;
                opacity:0.8;
            }
            input:hover{
                opacity: 1;
            } 
            h3{
                color:black;
                font-size:3em;
            }
            footer {
                font-weight:400;
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
        </style>
    </head>
    <body> <center><div class="Pagina"> <div id="sup"><img src="logoGobiernoCanarias.jpg"></div>
            <h3>
                Demandantes de empleo
            </h3>
            <div id="menu">
                <form action="tenerife.php">
                    <input type="submit" value="Tenerife">
                </form>
                <form action="localidad.php">
                    <input type="submit" value="Localidad">
                </form>
                <form action="enlaces.php">
                    <input type="submit" value="Enlaces">
                </form>
                <form action="interno.php">
                    <input type="submit" value="Acceso Interno">
                </form>
            </div>
            <footer>FERNANDO EZEQUIEL VERA 2ºDAW DSW</footer>
    </center>
    <?php
    ?>
</div>
</body>
</html>
