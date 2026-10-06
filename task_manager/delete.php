<?php
// =====================================================
// delete.php - DELETE: remove a task from the database.
// Only POST is allowed. GET requests are redirected.
// =====================================================

session_start(); // Start the session so flash messages work

require 'db.php';        // Need the database connection
require 'functions.php'; // Need setFlash()

// If this page is opened with GET (e.g. typing delete.php in the URL),
// do NOT delete anything; just redirect back to the list.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Read the hidden id sent by the delete form
$id = $_POST['id'] ?? '';

// The id must exist and be a number
if ($id === '' || !ctype_digit((string)$id)) {
    setFlash('Invalid task id.', 'error');
    header('Location: index.php');
    exit;
}

// Delete the row with a prepared statement (never trust input)
$stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
$stmt->execute([':id' => $id]);

setFlash('Task deleted successfully!', 'success');
header('Location: index.php');
exit;
?>
