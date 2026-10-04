<!DOCTYPE HTML>  
<html>
<body>  

<?php
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["website"])) {
    $website = "";
  } else {
    $website = test_input($_POST["website"]);
    if (!filter_var($website, FILTER_VALIDATE_URL)) {
      $websiteErr = "Invalid URL";
    }
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }
}

function test_input($valor) {
  $valor = trim($valor);
  $valor = stripslashes($valor);
  $valor = htmlspecialchars($valor);
  return $valor;
}
?>

<h2>Validacion formulario</h2>
<p>* Campo requerido</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Nombre: <input type="text" name="name" value="<?php echo $name;?>">
  * <?php echo $nameErr;?>
  <br><br>
  
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  * <?php echo $emailErr;?>
  <br><br>
  
  Web: <input type="text" name="website" value="<?php echo $website;?>">
  <?php echo $websiteErr;?>
  <br><br>
  
  Comentario: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
  <br><br>
  
  Genero:
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="Female") echo "checked";?> value="Female">Mujer
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="Male") echo "checked";?> value="Male">Hombre
  * <?php echo $genderErr;?>
  <br><br>
  
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
  echo "<h2>Your Input:</h2>";
  echo $name;
  echo "<br>";
  echo $email;
  echo "<br>";
  echo $website;
  echo "<br>";
  echo $comment;
  echo "<br>";
  echo $gender;
  ?>
  
  </body>
</html>
