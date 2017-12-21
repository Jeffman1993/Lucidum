<?php

 function query($sql){
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'lucidum';

    $link = new mysqli($host, $user, $pass, $db);

    if($link->error)
        die('Error: Can not connect to database. <br>' . $link->error);

    $res = $link->query($sql);

    $link->close();

    return $res;
}

?>

