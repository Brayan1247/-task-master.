<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Model/Task.php';

class TaskModelTest extends TestCase
{
    public function testNaoPodeSalvarTarefaSemTitulo(): void
    {
        $pdo = new PDO('sqlite::memory:');
        $model = new Task($pdo);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Título, Data e Responsável são obrigatórios.');

        $model->save('', 'Fazer compras', '2026-12-31', 'Brayan');
    }

    public function testSalvaEListaTarefaComOsCamposDoProjeto(): void
    {
        $pdo = new PDO('sqlite::memory:');
        $model = new Task($pdo);

        self::assertTrue($model->save('Comprar leite', 'Integral', '2026-12-31', 'Brayan'));
        self::assertSame('Integral', $model->getAll()[0]['descript']);
        self::assertSame('2026-12-31', $model->getAll()[0]['limitdate']);
        self::assertSame('Brayan', $model->getAll()[0]['createdby']);
    }
}
