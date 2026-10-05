<?php
$gente = array (
    array(
        'Familia' => 'Los Simpson ',
        'Padre' => 'Homer ',
        'Madre' => 'Marge ',
        'Hijos' => array('Bart ','Lisa ','Maggie ')
    ),
    array(
        'Familia' => 'Los Griffin ',
        'Padre' => 'Peter ',
        'Madre' => 'Lois ',
        'Hijos' => array('Chris ', 'Meg ','Stewie ')
    )
);

/*var_dump($gente);
echo"<br>";
print_r($gente);
echo"<br>";*/
echo"<ul>";
foreach ($gente as $familia) {
    foreach($familia as $persona) {
        if(is_array($persona)){
            echo"<ul>";
                foreach($persona as $hijo){
                    echo"<li>";
                        print($hijo);
                    echo"</li>";
                }
            echo"</ul>";
        } else {
            echo"<li>";
                print($persona);
            echo"</li>";
        }
    }
    echo"<br>";
}
echo"</ul>";
?>