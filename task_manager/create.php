<?php
// =====================================================
// create.php - CREATE: add a new task to the database.
// =====================================================

session_start(); // Start the session so flash messages work

require 'db.php';        // Need the database connection
require 'functions.php'; // Need clean(), setFlash(), showFlash(), validateTask()

// Default empty values so the form shows blank fields first
$title = '';
$description = '';
$category = '';
$priority = '';
$due_date = '';
$errors = []; // No errors yet

// Check if the form was submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the form values into variables and trim spaces
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $priority = trim($_POST['priority'] ?? '');
    $due_date = trim($_POST['due_date'] ?? '');

    // Validate the input using our reusable function
    $errors = validateTask($title, $category, $priority, $due_date, $categories, $priorities);

    if (count($errors) === 0) {
        // No errors: insert the new task with a prepared statement
        $stmt = $pdo->prepare(
            'INSERT INTO tasks (title, description, category, priority, due_date, completed)
             VALUES (:title, :description, :category, :priority, :due_date, 0)'
        );
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':category' => $category,
            ':priority' => $priority,
            ':due_date' => $due_date
        ]);

        // Show a success message on the next page, then redirect
        setFlash('Task added successfully!', 'success');
        header('Location: index.php');
        exit;
    }
    // If there ARE errors, we do NOT redirect; the form reappears below
    // with the user's typed values and the error messages.
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Task</h1>

        <?php showFlash(); ?>

        <?php if (count($errors) > 0): ?>
            <!-- Show all validation errors at the top of the form -->
            <div class="flash error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo clean($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- The form sends POST data to this same page -->
        <form method="POST" action="create.php">
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo clean($title); ?>">

            <label>Description:</label>
            <textarea name="description"><?php echo clean($description); ?></textarea>

            <label>Category:</label>
            <select name="category">
                <option value="">-- Choose --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo clean($cat); ?>" <?php if ($category === $cat) echo 'selected'; ?>>
                        <?php echo clean($cat); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Priority:</label>
            <select name="priority">
                <option value="">-- Choose --</option>
                <?php foreach ($priorities as $pri): ?>
                    <option value="<?php echo clean($pri); ?>" <?php if ($priority === $pri) echo 'selected'; ?>>
                        <?php echo clean($pri); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Due Date (YYYY-MM-DD):</label>
            <input type="text" name="due_date" value="<?php echo clean($due_date); ?>" placeholder="2026-10-15">

            <button type="submit">Save Task</button>
        </form>

        <p><a href="index.php">Back to list</a></p>
    </div>
</body>
</html>
