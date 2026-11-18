<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Model/Task.php';
require_once __DIR__ . '/../src/View/TaskViewInterface.php';
require_once __DIR__ . '/../src/Presenter/TaskPresenter.php';

class TaskPresenterTest extends TestCase
{
    public function testIndexFormataTitulosParaMaiusculo(): void
    {
        $modelMock = $this->createMock(Task::class);
        $modelMock->method('getAll')->willReturn([
            ['id' => 1, 'title' => 'estudar php', 'descript' => '', 'limitdate' => '', 'createdby' => '', 'done' => 0],
        ]);

        $viewMock = $this->createMock(TaskViewInterface::class);
        $viewMock->expects($this->once())
            ->method('displayTasks')
            ->with($this->callback(function (array $tasks): bool {
                return $tasks[0]['title'] === 'ESTUDAR PHP';
            }));

        $presenter = new TaskPresenter($modelMock, $viewMock);
        $presenter->index();
    }
}
