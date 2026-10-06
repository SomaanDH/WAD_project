<?php
// =====================================================
// edit.php - UPDATE: change an existing task.
// =====================================================

session_start(); // Start the session so flash messages work

require 'db.php';        // Need the database connection
require 'functions.php'; // Need clean(), setFlash(), showFlash(), validateTask()

$errors = []; // No errors yet

// --- Check the id coming from GET (?id=...) ---
// The id must exist, be numeric, and must be a real task.
$id = $_GET['id'] ?? ''; // Read id from the URL query string

if ($id === '' || !ctype_digit((string)$id)) {
    // Missing or not a number: show error and go back to the list
    setFlash('Invalid task id.', 'error');
    header('Location: index.php');
    exit;
}

// Load the task row from MySQL using a prepared statement
$stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = :id');
$stmt->execute([':id' => $id]);
$task = $stmt->fetch(); // One row as an array

if ($task === false) {
    // No task with that id: show error and go back
    setFlash('Task not found.', 'error');
    header('Location: index.php');
    exit;
}

// Fill variables with the current values, so the form is pre-filled
$title = $task['title'];
$description = $task['description'];
$category = $task['category'];
$priority = $task['priority'];
$due_date = $task['due_date'];
$completed = ($task['completed'] == 1); // bool: is the checkbox ticked?

// If the form was submitted with POST, validate and save
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read values typed by the user
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $priority = trim($_POST['priority'] ?? '');
    $due_date = trim($_POST['due_date'] ?? '');
    // Checkbox only sends a value when ticked, so default is 0
    $completed = isset($_POST['completed']);

    // Validate with our reusable function
    $errors = validateTask($title, $category, $priority, $due_date, $categories, $priorities);

    if (count($errors) === 0) {
        // Valid: run the UPDATE with a prepared statement
        $stmt = $pdo->prepare(
            'UPDATE tasks SET title = :title, description = :description,
             category = :category, priority = :priority, due_date = :due_date,
             completed = :completed WHERE id = :id'
        );
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':category' => $category,
            ':priority' => $priority,
            ':due_date' => $due_date,
            ':completed' => $completed ? 1 : 0, // true becomes 1, false becomes 0
            ':id' => $id
        ]);

        setFlash('Task updated successfully!', 'success');
        header('Location: index.php');
        exit;
    }
    // With errors, the form below shows the user's typed values again
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Task #<?php echo $id; ?></h1>

        <?php showFlash(); ?>

        <?php if (count($errors) > 0): ?>
            <div class="flash error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo clean($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Keep the id hidden so POST knows which task to save -->
        <form method="POST" action="edit.php?id=<?php echo $id; ?>">
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo clean($title); ?>">

            <label>Description:</label>
            <textarea name="description"><?php echo clean($description); ?></textarea>

            <label>Category:</label>
            <select name="category">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo clean($cat); ?>" <?php if ($category === $cat) echo 'selected'; ?>>
                        <?php echo clean($cat); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Priority:</label>
            <select name="priority">
                <?php foreach ($priorities as $pri): ?>
                    <option value="<?php echo clean($pri); ?>" <?php if ($priority === $pri) echo 'selected'; ?>>
                        <?php echo clean($pri); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Due Date (YYYY-MM-DD):</label>
            <input type="text" name="due_date" value="<?php echo clean($due_date); ?>">

            <label>
                <input type="checkbox" name="completed" value="1" <?php if ($completed) echo 'checked'; ?>>
                Mark as completed
            </label>

            <button type="submit">Save Changes</button>
        </form>

        <p><a href="index.php">Back to list</a></p>
    </div>
</body>
</html>
