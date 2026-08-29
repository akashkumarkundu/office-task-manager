# Office Task Tracker (ASTGD)

A modern, enterprise-grade Office Task & Deliverable Tracker application built with **Laravel 12**, **Tailwind CSS**, **Flux UI / Alpine.js**, and **SQLite/MySQL**.

---

## 📌 Project Overview

In day-to-day office operations, teams manage various tasks with different assignees, priority levels, and strict deadlines. **Office Task Tracker** provides complete clarity and real-time visibility over all organizational workflows:
- Tracks who is working on what (`Assigned To`).
- Identifies task urgency (`Priority`: Low, Medium, High).
- Monitors workflow stages (`Status`: Pending ➔ In Progress ➔ Completed).
- Automatically detects and flags **OVERDUE** deliverables.

---

## ✨ Features & Functional Checklist (100% Complete)

### 1. 📊 Executive Dashboard
- **Dynamic Real-Time Stats (From Database)**:
  - Total Tasks
  - Pending Tasks
  - In Progress Tasks
  - Completed Tasks
  - High Priority Tasks
- **Task Resolution Health**: Circular SVG progress percentage dial.
- **Due Soon Deadlines**: Separate module showing tasks due within the next 3 days.
- **Overdue Task Guardian**: Dedicated priority module for tasks with passed deadlines.
- **Team Workload Analytics**: Assignee task distribution and load balancing bar.
- **Recent Deliverables**: Live stream of the latest 5 tasks.

### 2. 🗂️ Task Management & CRUD
- **Task Attributes**: Title, Description, Assigned To, Priority, Status, Due Date, Created Date.
- **Workflow Transitions**: Pending ➔ In Progress ➔ Completed.
- **Server-Side Validation**:
  - `title`: Required (max 255 chars).
  - `assigned_to`: Required (custom message: *"Please select or enter the person responsible for this task."*).
  - `priority`: Required (`Low`, `Medium`, `High`).
  - `status`: Required (`Pending`, `In Progress`, `Completed`).
  - `due_date`: Required (valid date format).
  - No invalid data is saved to the database.
- **Delete Confirmation Modal**: Safe deletion modal dialog asking *"Are you sure you want to delete this task?"*.

### 3. 🔍 Search & Multi-Filter System
- **Search**: Multi-field search across `Task Title` and `Assigned To` (e.g. searching *"Rahim"* filters all tasks assigned to Rahim).
- **Status Filter**: `All`, `Pending`, `In Progress`, `Completed`.
- **Priority Filter**: `All`, `Low`, `Medium`, `High`.
- **Quick Filters**: One-click pills for *All Tasks*, *Overdue Tasks*, *Due Soon (3 Days)*, and *High Priority*.
- **Compound Query Execution**: Search and filters work harmoniously with pagination and preservation of GET parameters.

### 4. 🚨 Overdue Task Intelligence
- **Strict Logic**: `due_date < today` **AND** `status != 'Completed'`.
- Completed tasks are never marked as overdue.
- Distinct pulsing badge (**`OVERDUE`**) and warning icon across all views.
- Sorted by oldest deadline first.

### 5. ⚙️ Laravel Configuration Architecture & Feature Flags
- Configured through `.env` ➔ `config/tracker.php` ➔ `config()`:
  - `OFFICE_APP_NAME="ASTGD Task Tracker"`: Dynamic in Navbar, Hero & Browser Title.
  - `COMPANY_NAME="ASTGD"`: Displayed in Dashboard & Footer.
  - `COMPANY_EMAIL="office@example.com"`: Displayed in Footer `mailto:` link.
  - `TASKS_PER_PAGE=10`: Controls Eloquent pagination size.
  - `ENABLE_TASK_EXPORT=true`: Feature flag controlling CSV export button visibility & backend route access.
- **Environment Indicator**: Shows **`Environment: Development`** in the footer when running locally; automatically hidden in production.

### 6. 📱 Responsive UI & Theme Controls
- **Brightness & Theme Selector**: Light / Bright Mode, Dark Mode, and Auto/System Mode.
- **Display Layout Selector**: Desktop Wide Mode vs Mobile Compact Emulation Mode.
- Mobile drawer navigation and responsive table with horizontal touch scrolling.

---

## 🚀 Installation & Setup Guide

### 1. Clone Repository & Install Dependencies
```bash
git clone <repository-url>
cd office-task-manager

composer install
npm install
npm run build
```

### 2. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Ensure your `.env` contains the required settings:
```env
DB_CONNECTION=sqlite

# Office Task Tracker Configurations
OFFICE_APP_NAME="ASTGD Task Tracker"
COMPANY_NAME="ASTGD"
COMPANY_EMAIL="office@example.com"
TASKS_PER_PAGE=10
ENABLE_TASK_EXPORT=true
```

### 3. Database Migration
```bash
php artisan migrate
```

### 4. Start Development Server
```bash
php artisan serve
```
Visit `http://127.0.0.1:8000` in your web browser.

---

## 🧠 Architectural Concepts & Review Notes

### 1. Request Lifecycle Flow
$$\text{HTTP Request} \longrightarrow \text{routes/web.php} \longrightarrow \text{Controller} \longrightarrow \text{Eloquent Model} \longrightarrow \text{Database} \longrightarrow \text{Blade View}$$

1. **Route (`routes/web.php`)**: Captures HTTP verb and URL (e.g. `GET /tasks`), applies middleware (`auth`, `verified`), and maps to the Controller.
2. **Controller (`app/Http/Controllers/TaskController.php`)**: Processes incoming parameters, performs validation, and interacts with Models.
3. **Model (`app/Models/Task.php`)**: Eloquent ORM interface encapsulating business logic, scopes (`scopeOverdue`), and accessors (`is_overdue`, `days_overdue`).
4. **Database (`sqlite` / `mysql`)**: Stores persistent records in the `tasks` table.
5. **View (`resources/views/tasks/index.blade.php`)**: Renders reactive UI using Blade, Tailwind CSS, and Flux UI components.

### 2. Configuration Layer Flow
$$\text{.env File} \longrightarrow \text{config/tracker.php} \longrightarrow \text{config('tracker.*')} \longrightarrow \text{Application}$$
- **Why `.env` is used**: To separate environment-specific secrets and settings from code.
- **Why `.env` is in `.gitignore`**: To prevent accidental leakage of sensitive credentials to public GitHub repositories.
- **`.env.example` vs `.env`**: `.env.example` serves as a blueprint template containing all configuration keys without secrets.

---

## 🧪 Automated Test Suite

Run the full Pest feature test suite:
```bash
php artisan test --compact
```
**Results**: 41 tests passed, 121 assertions (100% pass rate).
