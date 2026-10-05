<!DOCTYPE HTML>  
<html>
  <head>
    <style>
      .error {color: #FF0000;}
    </style>
  </head>

  <body>  

    <?php
    $nombreErr = $emailErr = $genErr = $webErr = "";
    $nombre = $email = $gen = $coment = $web = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["nombre"])) {
        $nombreErr = "El nombre es obligatorio";
      } else {
        $nombre = test_input($_POST["nombre"]);
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]*$/", $nombre)) {
          $nombreErr = "Solo se permiten letras y espacios";
        }
      }
      
      if (empty($_POST["email"])) {
        $emailErr = "El email es obligatorio";
      } else {
        $email = test_input($_POST["email"]);
        if (!validar_email($email)) {
          $emailErr = "Formato de email invalido";
        }
      }
        
      if (empty($_POST["web"])) {
        $web = "";
      } else {
        $web = test_input($_POST["web"]);
        if (!validar_url($web)) {
          $webErr = "URL invalida";
        }
      }

      if (empty($_POST["coment"])) {
        $coment = "";
      } else {
        $coment = test_input($_POST["coment"]);
      }

      if (empty($_POST["gen"])) {
        $genErr = "El genero es obligatorio";
      } else {
        $gen = test_input($_POST["gen"]);
      }
    }

    function test_input($valor) {
      $valor = trim($valor);
      $valor = stripslashes($valor);
      $valor = htmlspecialchars($valor);
      return $valor;
    }

    function validar_email($email) {
      if (empty($email)) {
          return false;
      }
      return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function validar_url($url) {
        if (empty($url)) {
            return false;
        }
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    ?>

    <h2>Validación de formulario</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
      Nombre: <input type="text" name="nombre" value="<?php echo $nombre;?>">
      <span class="error"> <?php echo $nombreErr;?></span>
      <br><br>
      
      E-mail: <input type="text" name="email" value="<?php echo $email;?>">
      <span class="error"> <?php echo $emailErr;?></span>
      <br><br>
      
      Web: <input type="text" name="web" value="<?php echo $web;?>">
      <span class="error"><?php echo $webErr;?></span>
      <br><br>
      
      Comentario: <textarea name="coment" rows="5" cols="40"><?php echo $coment;?></textarea>
      <br><br>
      
      Género:
      <input type="radio" name="gen" <?php if (isset($gen) && $gen=="Mujer") echo "checked";?> value="Mujer">Mujer
      <input type="radio" name="gen" <?php if (isset($gen) && $gen=="Hombre") echo "checked";?> value="Hombre">Hombre
      <span class="error"><?php echo $genErr;?></span>
      <br><br>
      
      <input type="submit" nombre="submit" value="Enviar">  
    </form>

    <?php
    echo "<h2>Datos:</h2>";
    echo $nombre . "<br>";
    echo $email . "<br>";
    echo $web . "<br>";
    echo $coment . "<br>";
    echo $gen;
    ?>
  </body>
</html>
