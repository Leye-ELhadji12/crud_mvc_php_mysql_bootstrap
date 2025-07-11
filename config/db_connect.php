<?php 
    $dsn = "mysql:host=localhost;dbname=crud_app;charset=utf8mb4";
    $username = "root";
    $password = "";
    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (Exception $th) {
        die("Erreur de connexion à la base de donnée". $th->getMessage());
    }
?>