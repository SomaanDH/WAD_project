# Student Task Manager

A simple PHP and MySQL web app for managing student tasks. You can add tasks, review them in a list, edit their details, mark them as completed, and delete them.

## Requirements

- XAMPP (Apache and MySQL)
- PHP with PDO MySQL enabled (included with a standard XAMPP installation)
- A web browser

## Installation

1. Install and open the XAMPP Control Panel.
2. Start **Apache** and **MySQL**.
3. Copy the `task_manager` folder into XAMPP's web root, usually `C:\xampp\htdocs\task_manager\`.
4. Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
5. Choose **Import**, select the project's `database.sql` file, and click **Import** or **Go**. This creates the `task_manager` database and its `tasks` table.
6. Check the MySQL connection settings in `db.php`. The defaults are host `localhost`, database `task_manager`, username `root`, and a blank password. Update them if your local MySQL setup uses different credentials.
7. Visit [http://localhost/task_manager/](http://localhost/task_manager/) to use the app.

## Using the app

- Select **Add New Task** to create a task.
- Enter a title, description, category, priority, and due date. The due date must use `YYYY-MM-DD` format.
- Choose **Edit** to change a task or mark it completed.
- Choose **Delete** to remove a task.
- In the task list, overdue tasks are highlighted in red and completed tasks have a separate style.

## Features

- Create, list, update, and delete tasks (CRUD)
- Task fields: title, description, category, priority, due date, and completion status
- Server-side validation for required titles, allowed categories and priorities, title length, and valid dates
- Prepared PDO statements for database operations
- Escaped output and one-time success/error messages
- Overdue task highlighting

Available categories are **School**, **Personal**, **Health**, **Work**, and **Other**. Priorities are **Low**, **Medium**, and **High**.

## Project files

| File | Purpose |
| --- | --- |
| `index.php` | Lists tasks and shows their status and actions |
| `create.php` | Displays and processes the add-task form |
| `edit.php` | Displays and processes the edit-task form |
| `delete.php` | Deletes a task submitted through a POST form |
| `db.php` | Creates the PDO connection to MySQL |
| `functions.php` | Shared validation, output escaping, and flash-message helpers |
| `database.sql` | Creates the database and tasks table |
| `style.css` | Styles the pages and task statuses |

## Database table

The `tasks` table contains an auto-incrementing ID, title, description, category, priority, due date, completion flag, and creation timestamp. The schema is defined in `database.sql`.

## Student details

- **Name:** Su Man
- **Student ID:** 202300232

## AI-use reflection

- **AI tool(s) used:** ChatGPT
- **Three examples of how AI helped me:**
  1. Helped organize the README into clear sections.
  2. Helped explain how to install and run the project with XAMPP and MySQL.
  3. Helped describe the app's features and project files based on the code.
- **One AI-generated suggestion or code that I changed or rejected:**
  - The AI suggested keeping this reflection blank for me to complete. I replaced that suggestion with an accurate description of how AI helped with my README.
  - I did this because the reflection should describe my actual use of AI.
- **The part of this application I understand least:** [Write the part you find most difficult, such as the database connection, form validation, or PHP sessions.]
