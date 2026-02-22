# 🚀 TaskFlow Dashboard (v1.0.0)

A professional, high-performance To-Do Dashboard built with **Core PHP**, **MySQL (PDO)**, and **Bootstrap 5**. Designed with a SaaS-like interface, featuring real-time AJAX interactions and a clean card-based UI.

## 🛠️ Tech Stack & Architecture
- **Backend:** PHP 8.x (Core) using PDO Prepared Statements (SQLi Protection).
- **Database:** MySQL with Foreign Key constraints and Indexing for performance.
- **Frontend:** Bootstrap 5, Vanilla JS + jQuery (for AJAX), SweetAlert2 (Alerts), and Sortable.js (Drag-and-Drop).
- **Security:** CSRF-ready architecture, XSS filtering via `htmlspecialchars`, and sensitive data separation.

## 🌟 Key Features
- **Dynamic Dashboard:** Animated task counters (Total, Pending, Completed).
- **Website/Category System:** Task organization with color-coded labels.
- **Power Search:** Instant AJAX filtering by Title, Category, Priority, and Status.
- **UX Excellence:** - Dark/Light mode toggle.
  - Smooth task reordering via drag-and-drop.
  - Toast notifications and SweetAlert2 confirmations.
  - Responsive card-based layout (no clunky tables).

## ⚙️ Installation & Setup
1.  **Clone/Extract:** Place the `taskflow` folder in your server's root (e.g., `C:/xampp/htdocs` or `/var/www/html`).
2.  **Database Setup:**
    - Open **phpMyAdmin**.
    - Create a database named `taskflow_db`.
    - Import the file located at `sql/database.sql`.
3.  **Configuration:**
    - Open `config/db.php`.
    - Update `$user` and `$pass` to match your local MySQL credentials.
4.  **Access:**
    - Navigate to `http://localhost/taskflow` in your browser.

## 📁 File Structure Explaination
- `/api`: Contains the "Engine." Pure PHP logic that handles requests and returns JSON.
- `/assets`: Static resources (CSS/JS). No PHP logic here for better caching.
- `/config`: Database connection singleton.
- `/includes`: Reusable functions (security, formatting, helpers).
- `/sql`: Database schema and initial seed data.