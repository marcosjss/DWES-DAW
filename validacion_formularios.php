<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <p>Nombre: <input type="text" name ="nombre"></p>
    <br>
    <p>E-mail: <input type="text" name ="email" value="<?php echo $email;?>"></p>
    <span class="error">* <?php echo $emailErr;?></span><br><br>

    <p><input type="radio" name="sexo"
        <?php if (isset($sexo) && $sexo=="mujer") echo "checked";?>
        value="mujer"> Mujer
    <input type="radio" name="sexo"
        <?php if (isset($sexo) && $sexo=="hombre") echo "checked";?>
        value="hombre"> Hombre</p>
    <span class="error">* <?php echo $sexoErr;?></span><br><br>
    <p>Comentarios: <input type="text" name ="comentario"></p>
</form>

<?php
//Nombre
if (empty($_POST["nombre"])) {
    $nameErr = "El nombre es obligatorio";
} else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $nameErr = "Únicamente se permiten letras y espacios";
}}

//Email
if (empty($_POST["email"])) {
    $emailErr = "Se requiere Email";
} else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Fomato de Email invalido";
    }
}

//Sexo
if (empty($_POST["sexo"])) {
    $emailErr = "Se requiere un sexo";
}
?>
