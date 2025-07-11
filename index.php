<?php

    require_once __DIR__ . '/config/db_connect.php'; 

    require_once __DIR__ . '/controller/UserController.php'; 

    $userController = new UserController($pdo);

    $action = $_GET['action'] ?? 'list';

    switch ($action) {
        case 'list':
            $userController->listUsers();
            break;
        case 'create':
            $userController->create(); 
            break;
        case 'edit':
            $userController->edit(); 
            break;
        case 'delete':
            $userController->delete(); 
            break;
        default:
            http_response_code(404);
            echo "<h1>404 Not Found</h1><p>The requested URL was not found on this server.</p><p><a href=\"index.php?action=list\">Retour à la page d'accueil</a></p>";
            break;
    }
?>