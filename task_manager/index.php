<?php
// =====================================================
// index.php - READ: shows every task in a table.
// =====================================================

session_start(); // Start the session so flash messages work

require 'db.php';        // Need the database connection
require 'functions.php'; // Need clean(), showFlash(), $priorities

// Fetch ALL tasks from MySQL, newest first
$stmt = $pdo->query('SELECT * FROM tasks ORDER BY id DESC');
$tasks = $stmt->fetchAll(); // Put all rows into an array

// Today's date (YYYY-MM-DD) for the overdue check
$today = date('Y-m-d');

// Count tasks for a simple counter display
$totalTasks = count($tasks);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Student Task Manager</h1>

        <?php showFlash(); ?> <!-- Show success/error message if one was stored -->

        <p>Total tasks: <?php echo $totalTasks; ?></p>

        <p><a class="button" href="create.php">+ Add New Task</a></p>

        <?php if ($totalTasks === 0): ?>
            <!-- Show this friendly message when there are no rows -->
            <p>No tasks found.</p>
        <?php else: ?>
            <!-- Table with one row per task -->
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

                <?php foreach ($tasks as $task): ?>
                    <?php
                    // ===== CHALLENGE: highlight overdue tasks =====
                    // A task is overdue if it is NOT completed and its
                    // due date is before today.
                    $isOverdue = ($task['completed'] == 0 && $task['due_date'] !== null && $task['due_date'] < $today);
                    // Choose the CSS class for the row based on overdue/completed
                    if ($isOverdue) {
                        $rowClass = 'overdue';
                    } elseif ($task['completed'] == 1) {
                        $rowClass = 'done';
                    } else {
                        $rowClass = '';
                    }
                    // ===== END CHALLENGE =====
                    ?>
                    <tr class="<?php echo $rowClass; ?>">
                        <td><?php echo $task['id']; ?></td>
                        <td><?php echo clean($task['title']); ?></td>
                        <td><?php echo clean($task['category']); ?></td>
                        <td><?php echo clean($task['priority']); ?></td>
                        <td><?php echo clean($task['due_date']); ?></td>
                        <td><?php echo ($task['completed'] == 1) ? 'Completed' : 'Pending'; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $task['id']; ?>">Edit</a>

                            <!-- Delete uses a POST form, NOT a GET link (safer) -->
                            <form method="POST" action="delete.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
