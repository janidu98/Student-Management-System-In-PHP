<?php
    if(isset($_GET["id"])) {
        $id = $_GET["id"];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "student_manager";

        //create connection
        $connection = new mysqli($servername, $username, $password, $database);

        $sql = "DELETE FROM students WHERE id=$id";
        $connection->query($sql);
    }

    header("location: /2018COM52/Project/index.php");
    exit;
?>