<?php
spl_autoload_register(function ($class) {
    $directories = ['Model', 'Controller'];

    foreach ($directories as $directory) {
        $file = __DIR__ . '/src/' . $directory . '/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$pdo = new PDO('sqlite:' . __DIR__ . '/tasks.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$controller = new TaskController($pdo);
$action = $_GET['action'] ?? 'index';

if (in_array($action, ['index', 'create', 'complete', 'delete'], true)) {
    $controller->$action();
} else {
    http_response_code(404);
    echo 'Página não encontrada';
}
