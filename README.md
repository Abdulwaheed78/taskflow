CareComp Tasks

CareComp Tasks is a lightweight, web-based task management application that allows users to create, manage, and track tasks across different websites with priority levels. It features real-time search, filtering, pagination, and task summaries.

Features

Create Tasks: Add tasks with title, associated website, and priority (High, Medium, Low).

Edit Tasks: Inline editing for title, website, priority, and status.

Delete Tasks: Remove unwanted tasks.

Task Summary: View overall and per-website task summaries, including Pending, Completed, and Total counts.

Filters: Filter tasks by status, priority, website, or search by title.

Pagination: Navigate through tasks using Previous/Next buttons and jump to a specific page via input.

Hover Details: Hover over task titles to see full task details.

Responsive Design: Works on desktops and tablets, built using Bootstrap 5.

Tech Stack

Frontend: HTML5, CSS3, Bootstrap 5, jQuery

Backend: PHP

Database: MySQL

Icons: Bootstrap Icons

Installation

Clone the repository

git clone https://github.com/yourusername/carecomp-tasks.git
cd carecomp-tasks


Setup MySQL Database

Create a database, e.g., carecomp_tasks.

Import the tasks.sql file (contains the tasks table structure).

Update database credentials in db.php.

<?php
$con = mysqli_connect("localhost", "username", "password", "carecomp_tasks");
if (!$con) die("Database connection failed: " . mysqli_connect_error());
?>


Run the application

Place files in your local server folder (htdocs for XAMPP, www for WAMP).

Access via browser: http://localhost/carecomp-tasks/.

Database Schema

tasks table structure:

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` enum('pending','completed') DEFAULT 'pending',
  `priority` enum('Low','Medium','High') DEFAULT 'Medium',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `website` varchar(255) DEFAULT 'General',
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


You can also seed the database with random tasks for testing (e.g., 20,000 tasks).

Usage

Add a Task: Enter a task title, website, and select priority → press Enter.

Edit Task: Click on the title, website, status, or priority fields → modify → press Enter or change select value.

Delete Task: Click the trash icon to remove a task.

Search/Filter:

Type in the search box to filter by title.

Use dropdowns to filter by status, priority, or website.

Pagination:

Use < or > buttons to navigate pages.

Enter a page number and click “Go” to jump directly to a page.

Hover Details: Hover over the title input to view task details in a tooltip-like card.

Styling

Tasks are highlighted based on priority:

High → Red border

Medium → Yellow border

Low → Green border

Tables and summary cards have a transparent design with hover effects.

Buttons and inputs are rounded for modern UI.

Known Issues / Notes

Pagination is limited to “Previous/Next” and Go-to-page input to handle large datasets efficiently.

Search works with title filtering; ensure that AJAX requests include the search query.

License

MIT License © 2025 Abdul Waheed Chaudhary
