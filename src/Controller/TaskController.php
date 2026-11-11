<?php

class TaskController
{
    private Task $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new Task($pdo);
    }

    public function index(?string $error = null): void
    {
        $tasks = $this->model->getAll();
        require __DIR__ . '/../View/list.php';
    }

    public function create(): void
    {
        try {
            $this->model->save(
                trim($_POST['title'] ?? ''),
                trim($_POST['descript'] ?? ''),
                trim($_POST['limitdate'] ?? ''),
                trim($_POST['createdby'] ?? '')
            );
            header('Location: index.php');
            exit;
        } catch (InvalidArgumentException $exception) {
            $this->index($exception->getMessage());
        }
    }

    public function complete(): void
    {
        $this->model->complete((int) ($_GET['id'] ?? 0));
        header('Location: index.php');
        exit;
    }

    public function delete(): void
    {
        $this->model->delete((int) ($_GET['id'] ?? 0));
        header('Location: index.php');
        exit;
    }
}
