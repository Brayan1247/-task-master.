<?php

class Task
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->exec(
            'CREATE TABLE IF NOT EXISTS tasks (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                done INTEGER DEFAULT 0,
                descript TEXT,
                limitdate DATE,
                createdby TEXT
            )'
        );
    }

    public function getAll(): array
    {
        $statement = $this->pdo->query('SELECT * FROM tasks ORDER BY id DESC');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(string $title, string $description, string $dueDate, string $createdBy): bool
    {
        if (trim($title) === '' || trim($dueDate) === '' || trim($createdBy) === '') {
            throw new InvalidArgumentException('Título, Data e Responsável são obrigatórios.');
        }

        $statement = $this->pdo->prepare(
            'INSERT INTO tasks (title, descript, limitdate, createdby)
             VALUES (:title, :description, :due_date, :created_by)'
        );
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':due_date', $dueDate);
        $statement->bindValue(':created_by', $createdBy);

        return $statement->execute();
    }

    public function complete(int $id): int
    {
        $statement = $this->pdo->prepare('UPDATE tasks SET done = 1 WHERE id = :id');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }

    public function delete(int $id): int
    {
        $statement = $this->pdo->prepare('DELETE FROM tasks WHERE id = :id');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}
