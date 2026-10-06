<?php
// =====================================================
// db.php - Connects PHP to MySQL using PDO.
// WHY: every page needs the same database connection,
// so we put it in one file and include it everywhere.
// =====================================================

// Start output buffering is NOT needed; just set error mode etc.
try {
    // Create the PDO connection: host, database name, username, password
    $pdo = new PDO(
        'mysql:host=localhost;dbname=task_manager;charset=utf8mb4', // Which database to connect to
        'root',   // MySQL username (default in XAMPP)
        '',       // MySQL password (empty by default in XAMPP)
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw errors so try/catch can catch them
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Fetch rows as simple arrays
        )
    );
} catch (PDOException $e) {
    // If connection fails, stop the page and show the error
    die('Database connection failed: ' . $e->getMessage());
}
?>
