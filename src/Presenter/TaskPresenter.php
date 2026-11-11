<?php

class TaskPresenter
{
    private Task $model;
    private TaskViewInterface $view;

    public function __construct(Task $model, TaskViewInterface $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function index(): void
    {
        try {
            $tasks = $this->model->getAll();

            foreach ($tasks as &$task) {
                $task['title'] = strtoupper($task['title']);
            }
            unset($task);

            $this->view->displayTasks($tasks);
        } catch (Exception $exception) {
            $this->view->showError($exception->getMessage());
        }
    }

    public function create(string $title, string $description, string $dueDate, string $createdBy): void
    {
        try {
            $this->model->save($title, $description, $dueDate, $createdBy);
            header('Location: index.php');
            exit;
        } catch (Exception $exception) {
            $this->view->showError($exception->getMessage());
        }
    }

    public function complete(int $id): void
    {
        $this->model->complete($id);
        header('Location: index.php');
        exit;
    }

    public function delete(int $id): void
    {
        $this->model->delete($id);
        header('Location: index.php');
        exit;
    }
}
