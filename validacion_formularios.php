<!DOCTYPE HTML>  
<html>
<body>  

<?php
// Definición de variables y asignación de valores vacíos
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // Comprueba que el nombre solo contiene letras y espacios[cite: 2, 3]
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // Comprueba si el formato de email es válido[cite: 2, 3]
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["website"])) {
    $website = "";
  } else {
    $website = test_input($_POST["website"]);
    // Comprueba si el formato de la URL es válido[cite: 3]
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

// Función para sanear los datos de entrada[cite: 1]
function test_input($valor) {
  $valor = trim($valor);
  $valor = stripslashes($valor);
  $valor = htmlspecialchars($valor);
  return $valor;
}
?>

<h2>PHP Form Validation Example</h2>
<p>* required field</p>
<!-- El formulario se envía a sí mismo mediante $_SERVER["PHP_SELF"][cite: 1] -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  * <?php echo $nameErr;?>
  <br><br>
  
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  * <?php echo $emailErr;?>
  <br><br>
  
  Website: <input type="text" name="website" value="<?php echo $website;?>">
  <?php echo $websiteErr;?>
  <br><br>
  
  Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
  <br><br>
  
  Gender:
  <!-- Mantiene la selección del radio button tras el envío[cite: 1] -->
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="Female") echo "checked";?> value="Female">Female
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="Male") echo "checked";?> value="Male">Male
  * <?php echo $genderErr;?>
  <br><br>
  
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
// Muestra los valores introducidos sean correctos o no[cite: 3]
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
