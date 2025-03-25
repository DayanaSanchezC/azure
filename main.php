<?php
// Archivo donde se almacenarán las tareas
define("TASKS_FILE", "tasks.json");

// Función para obtener las tareas
function getTasks() {
    if (!file_exists(TASKS_FILE)) return [];
    return json_decode(file_get_contents(TASKS_FILE), true) ?: [];
}

// Función para guardar las tareas
function saveTasks($tasks) {
    file_put_contents(TASKS_FILE, json_encode($tasks, JSON_PRETTY_PRINT));
}

// Manejo de solicitudes
$tasks = getTasks();

// Agregar tarea
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['task'])) {
    $tasks[] = ["task" => $_POST['task'], "done" => false];
    saveTasks($tasks);
}

// Marcar como completada o eliminar tarea
if (isset($_GET['action'], $_GET['index'])) {
    $index = (int)$_GET['index'];
    if ($_GET['action'] === "done") $tasks[$index]['done'] = !$tasks[$index]['done'];
    if ($_GET['action'] === "delete") array_splice($tasks, $index, 1);
    saveTasks($tasks);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirigir para evitar reenvío del formulario
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-4">📌 Lista de Tareas</h2>
        <form method="post" class="mb-4">
            <div class="input-group">
                <input type="text" name="task" class="form-control" placeholder="Nueva tarea..." required>
                <button class="btn btn-primary">Agregar</button>
            </div>
        </form>
        <ul class="list-group">
            <?php foreach ($tasks as $index => $task): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="<?= $task['done'] ? 'text-decoration-line-through text-muted' : '' ?>">
                        <?= htmlspecialchars($task['task']) ?>
                    </span>
                    <div>
                        <a href="?action=done&index=<?= $index ?>" class="btn btn-sm <?= $task['done'] ? 'btn-secondary' : 'btn-success' ?>">✔</a>
                        <a href="?action=delete&index=<?= $index ?>" class="btn btn-sm btn-danger">✖</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
