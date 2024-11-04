<?php
session_start();
require_once('connect.php');

if (isset($_POST['add_task'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $sql = "INSERT INTO tasks (title) VALUES ('$title')";
    mysqli_query($conn, $sql);

    header('Location: index.php');
}

if (isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE tasks SET status = '$status' WHERE id = $id";
    mysqli_query($conn, $sql);

    header('Location: index.php');
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM tasks WHERE id = $id";
    mysqli_query($conn, $sql);

    header('Location: index.php');
}

$sql = "SELECT * FROM tasks ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-100 select-none">
    <div class="container mx-auto p-5">

        <h2 class="text-2xl font-bold text-center mb-6">Lista de Tarefas</h2>

        <form method="POST" class="flex mb-4">
            <input type="text" name="title" class="flex-grow p-2 border border-zinc-300 rounded-l-md focus:outline-none" placeholder="Nova Tarefa" required>
            <button type="submit" name="add_task" class="bg-sky-600 text-zinc-50 px-4 py-2 rounded-r-md hover:bg-sky-700">Adicionar</button>
        </form>

        <div class="relative w-full overflow-auto select-none">
            <table class="w-full bg-zinc-50 border border-zinc-200 rounded-md caption-bottom text-lg overflow-hidden">
                <thead class="bg-zinc-200">
                    <tr class="h-12 border-b">
                        <th class="px-2 text-left align-middle font-medium w-12 text-center">Id</th>
                        <th class="px-2 text-left align-middle font-medium text-center">Tarefa</th>
                        <th class="px-2 text-left align-middle font-medium w-40 text-center">Status</th>
                        <th class="px-2 text-left align-middle font-medium w-32"></th>
                    </tr>
                </thead>
                
                <tbody>
                <?php foreach ($result as $row): ?>
                    <tr class="border-b transition-colors hover:bg-zinc-100">
                        <td class="p-2 text-center"><?= $row['id']; ?></td>
                        <td class="p-2 select-all"><?= $row['title']; ?></td>
                        <td class="p-2">
                            <form method="POST" class="inline">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <select name="status" class="p-1 border border-zinc-300 rounded-md focus:outline-none" onchange="this.form.submit()">
                                    <option value="pending" <?php if ($row['status'] === 'pending') echo 'selected'; ?>>⏳ Pendente</option>
                                    <option value="in_progress" <?php if ($row['status'] === 'in_progress') echo 'selected'; ?>>🕛 Em andamento</option>
                                    <option value="completed" <?php if ($row['status'] === 'completed') echo 'selected'; ?>>✅ Concluído</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </td>
                        <td class="p-2">
                            <a href="?delete=<?= $row['id']; ?>" class="bg-rose-500 text-zinc-50 px-2 py-1 rounded-md hover:bg-rose-600">🗑️ Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
