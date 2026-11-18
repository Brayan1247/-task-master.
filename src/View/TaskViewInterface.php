<?php

interface TaskViewInterface
{
    public function displayTasks(array $tasks): void;

    public function showError(string $message): void;
}
