<?php
spl_autoload_register(function ($class) {
    $directories = ['Model', 'Presenter', 'View'];

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

$model = new Task($pdo);
$view = new TaskHtmlView();
$presenter = new TaskPresenter($model, $view);
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        $presenter->create(
            trim($_POST['title'] ?? ''),
            trim($_POST['descript'] ?? ''),
            trim($_POST['limitdate'] ?? ''),
            trim($_POST['createdby'] ?? '')
        );
        break;
    case 'complete':
        $presenter->complete((int) ($_GET['id'] ?? 0));
        break;
    case 'delete':
        $presenter->delete((int) ($_GET['id'] ?? 0));
        break;
    case 'index':
        $presenter->index();
        break;
    default:
        http_response_code(404);
        echo 'Página não encontrada';
}
