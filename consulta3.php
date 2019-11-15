
<html> 
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  </head>
    <body class="m-3" style="overflow-x: hidden;">
 
    <?php
    $host = "localhost";
    $puerto = "3306";
    $usuario = "root";
    $contrasena = "12345";
    $baseDeDatos ="soproyecto";
    $tabla = "datos";
 
    function Conectarse()
   {
     global $host, $puerto, $usuario, $contrasena, $baseDeDatos, $tabla;
 
     if (!($link = mysqli_connect($host.":".$puerto, $usuario, $contrasena))) 
     {   
        echo "Error conectando a la base de datos."; 
       exit(); 
            }
     else
      {
       echo "Listo, estamos conectados.";
      }
     if (!mysqli_select_db($link, $baseDeDatos)) 
      { 
        echo "Error seleccionando la base de datos."; 
        exit(); 
      }
     else
      {
       echo "Obtuvimos la base de datos $baseDeDatos sin problema.";
     }
   return $link; 
    } 
    
     $link = Conectarse();
 
   $query = "SELECT * FROM $tabla;";
 
    $result = mysqli_query($link, $query); 
 
   ?>
 
<div class="m-3 row h-100 w-100 card" style="overflow-x:hidden">

    <diV class="col-lg-12 col-md-12">
        <h2 class="text-white text-center" style="background-color: #3e444a;">DATOS CAPTURADOS POR EL SENSOR</h2>
        <table class="table table-striped table-dark" style="text-align:center">
        <thead>
            <tr>
            <th scope="col">id</th>
            <th scope="col">Fecha</th>
            <th scope="col">Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while($row = mysqli_fetch_array($result))
                { 
 
                    printf("<tr>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    </tr>", $row["id"],$row["fecha"],$row["hora"]);  
                }  
                mysqli_free_result($result); 
                mysqli_close($link); 
            ?>
        </tbody>
    </table>
</diV>

    </div>

   </body> 
 
    </html>
