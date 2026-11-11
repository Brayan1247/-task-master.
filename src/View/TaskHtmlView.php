<?php

class TaskHtmlView implements TaskViewInterface
{
    public function displayTasks(array $tasks): void
    {
        $error = null;
        require __DIR__ . '/list.php';
    }

    public function showError(string $message): void
    {
        $error = $message;
        $tasks = [];
        require __DIR__ . '/list.php';
    }
}
