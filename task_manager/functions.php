<?php
// =====================================================
// functions.php - Reusable helper functions.
// WHY: instead of repeating the same code everywhere,
// we write it once here and call it from any page.
// =====================================================

// Allowed categories and priorities (arrays we validate against)
$categories = ['School', 'Personal', 'Health', 'Work', 'Other'];
$priorities = ['Low', 'Medium', 'High'];

// clean() - Escapes user text so it is safe to show in HTML.
// WHY: prevents XSS attacks and broken HTML in the page.
function clean($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// setFlash() - Stores a one-time message in the session.
// WHY: after a redirect the variables are lost, but the
// session keeps the message so we can show it once.
function setFlash($message, $type) {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type; // 'success' or 'error'
}

// showFlash() - Prints the flash message once, then deletes it.
// WHY: the message should appear one time only.
function showFlash() {
    if (isset($_SESSION['flash_message'])) {
        $type = $_SESSION['flash_type'];
        // Print a styled div with the message (escaped)
        echo '<div class="flash ' . clean($type) . '">' . clean($_SESSION['flash_message']) . '</div>';
        // Remove it so it does not show again on the next page load
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    }
}

// validateTask() - Checks the form data and returns an array of errors.
// WHY: we must never trust form data; the server checks everything.
// Returns an empty array [] when everything is valid.
function validateTask($title, $category, $priority, $due_date, $categories, $priorities) {
    $errors = []; // Start with no errors

    // Title: required, max 150 characters
    if ($title === '') {
        $errors[] = 'Title is required.';
    } elseif (strlen($title) > 150) {
        $errors[] = 'Title must be 150 characters or less.';
    }

    // Category: must be one of the allowed categories
    if (!in_array($category, $categories)) {
        $errors[] = 'Please choose a valid category.';
    }

    // Priority: must be one of the allowed priorities
    if (!in_array($priority, $priorities)) {
        $errors[] = 'Please choose a valid priority.';
    }

    // Due date: must be a real date in YYYY-MM-DD format
    $dateCheck = DateTime::createFromFormat('Y-m-d', $due_date);
    if ($due_date === '' || $dateCheck === false || $dateCheck->format('Y-m-d') !== $due_date) {
        $errors[] = 'Due date must be a valid date (YYYY-MM-DD).';
    }

    return $errors;
}
?>
