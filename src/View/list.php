<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Master - MVC</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; color: #333; display: flex; justify-content: center; padding-top: 50px; }
        .container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h1 { font-size: 1.5rem; text-align: center; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .error { color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 4px; font-size: 0.9rem; }
        .form-group { display: flex; gap: 10px; margin-top: 20px; margin-bottom: 20px; }
        input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px; width: 40px; }
        textarea { flex: 1; min-height: 72px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font: inherit; resize: vertical; }
        .task-form { flex-direction: column; }
        .task-form input, .task-form button { box-sizing: border-box; width: 100%; padding: 10px; }
        .task-details { display: flex; flex-direction: column; gap: 4px; min-width: 0; overflow-wrap: anywhere; }
        .task-description { color: #6b7280; font-size: 0.9rem; }
        button { background: #2563eb; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; }
        button:hover { background: #1d4ed8; }
        ul { list-style: none; padding: 0; }
        li { display: flex; justify-content: space-between; align-items: center; padding: 12px; border-bottom: 1px solid #eee; }
        li.done span { text-decoration: line-through; color: #9ca3af; }
        .actions a { text-decoration: none; margin-left: 10px; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <h1>Task Master (MVC Edition)</h1>

    <?php if ($error !== null): ?>
        <div class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=create" class="form-group task-form">
        <input type="text" name="title" placeholder="O que precisa ser feito?" autocomplete="off" required>
        <textarea name="descript" placeholder="Descrição (opcional)"></textarea>
        <input type="date" name="limitdate" aria-label="Data de vencimento" required>
        <input type="text" name="createdby" placeholder="Responsável" autocomplete="off" required>
        <button type="submit">Adicionar</button>
    </form>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li class="<?php echo $task['done'] ? 'done' : ''; ?>">
                <div class="task-details">
                    <strong><?php echo htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8'); ?></strong>
                    <?php if (!empty($task['descript'])): ?>
                        <span class="task-description"><?php echo htmlspecialchars($task['descript'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php endif; ?>
                    <span>Vencimento: <?php echo htmlspecialchars($task['limitdate'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                    <span>Responsável: <?php echo htmlspecialchars($task['createdby'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                </div>

                <div class="actions">
                    <?php if (!$task['done']): ?>
                        <a href="index.php?action=complete&amp;id=<?php echo (int) $task['id']; ?>" title="Concluir">✅</a>
                    <?php endif; ?>
                    <a href="index.php?action=delete&amp;id=<?php echo (int) $task['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');" title="Excluir">❌</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
