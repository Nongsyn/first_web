
<?php

require_once __DIR__ . '/controllers/StudentController.php';
require_once __DIR__ . '/controllers/MajorController.php';

$page = $_GET['page'] ?? 'student';

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>

    <style>
        :root {
            color-scheme: light;
            --ink: #17243b;
            --muted: #718096;
            --accent: #286cdd;
            --accent-soft: #edf4ff;
            --line: #e7edf4;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, sans-serif;
            margin: 0;
            padding: clamp(20px, 5vw, 64px) 20px;
            color: var(--ink);
            background:
                radial-gradient(ellipse at 12% 0%, #e8f2ff 0, transparent 38%),
                #f5f7fb;
        }

        .container {
            width: min(100%, 1080px);
            margin: 0 auto;
        }

        .site-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 30px;
        }

        .brand-mark {
            display: grid;
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            place-items: center;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(145deg, #428cf2, #225bc5);
            box-shadow: 0 8px 18px #286cdd35;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: .03em;
        }

        .brand-mark svg {
            width: 26px;
            height: 26px;
        }

        .brand-copy h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 750;
            letter-spacing: -.025em;
        }

        .brand-copy p {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        nav {
            display: flex;
            gap: 8px;
            margin-bottom: 18px;
        }

        nav a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 42px;
            padding: 0 17px;
            border: 1px solid transparent;
            border-radius: 12px;
            color: #617087;
            text-decoration: none;
            font-size: 14px;
            font-weight: 650;
            transition: background .18s ease, color .18s ease, border-color .18s ease;
        }

        .nav-icon {
            width: 18px;
            height: 18px;
            flex: 0 0 auto;
        }

        nav a:hover {
            color: var(--accent);
            background: #fff;
        }

        nav a.active {
            color: var(--accent);
            border-color: #dce9ff;
            background: #fff;
            box-shadow: 0 3px 10px #1d35570b;
        }

        .content-panel {
            min-height: 360px;
            padding: clamp(22px, 4vw, 38px);
            border: 1px solid #e9eef5;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 18px 55px #2039570c;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            text-align: left;
        }

        thead th {
            padding: 14px 18px;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            color: #7a8799;
            background: #f8fafd;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .075em;
            text-transform: uppercase;
        }

        thead th:first-child {
            border-left: 1px solid var(--line);
            border-radius: 12px 0 0 12px;
        }

        thead th:last-child {
            border-right: 1px solid var(--line);
            border-radius: 0 12px 12px 0;
        }

        tbody td {
            padding: 16px 18px;
            border-bottom: 1px solid #edf1f6;
            color: #435168;
            font-size: 14px;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        tbody tr:not(.empty-row):hover td {
            background: #fbfdff;
        }

        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 26px;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: var(--accent);
            font-size: 10px;
            font-weight: 750;
            letter-spacing: .14em;
        }

        .page-heading h2 {
            margin: 0;
            font-size: clamp(23px, 3vw, 29px);
            letter-spacing: -.04em;
        }

        .page-description {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 14px;
        }

        .record-count {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex: 0 0 auto;
            padding: 9px 13px;
            border: 1px solid #dfeaff;
            border-radius: 999px;
            color: #315eaa;
            background: var(--accent-soft);
            font-size: 13px;
            font-weight: 700;
        }

        .count-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #3982e8;
        }

        .table-wrap {
            overflow-x: auto;
        }

        .id-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 7px;
            color: #526782;
            background: #f1f4f8;
            font-size: 12px;
            font-weight: 700;
        }

        .empty-row td {
            padding: 44px 18px;
            color: var(--muted);
            text-align: center;
        }

        @media (max-width: 600px) {
            body {
                padding: 24px 14px;
            }

            .site-header {
                margin-bottom: 22px;
            }

            .content-panel {
                padding: 22px 16px;
                border-radius: 18px;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }

            thead th,
            tbody td {
                padding-right: 13px;
                padding-left: 13px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <header class="site-header">
        <div class="brand-mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                <path d="m2 9 10-5 10 5-10 5L2 9Z" />
                <path d="M6 11v4.5c3.5 2.5 8.5 2.5 12 0V11M22 9v5" />
            </svg>
        </div>
        <div class="brand-copy">
            <h1>ระบบจัดการนักเรียน</h1>
            <p>Student Management System</p>
        </div>
    </header>

    <nav aria-label="เมนูหลัก">
        <a href="Index.php?page=student"
           aria-current="<?= $page === 'student' ? 'page' : 'false' ?>"
           class="<?= $page === 'student' ? 'active' : '' ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                <circle cx="9" cy="8" r="3.5" />
                <path d="M2.5 20c0-3.3 2.8-5.5 6.5-5.5s6.5 2.2 6.5 5.5M16 5.5a3.5 3.5 0 0 1 0 6.8M18 14.8c2.2.8 3.5 2.6 3.5 5.2" />
            </svg>
            นักเรียน
        </a>

        <a href="Index.php?page=major"
           aria-current="<?= $page === 'major' ? 'page' : 'false' ?>"
           class="<?= $page === 'major' ? 'active' : '' ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                <path d="m2 9 10-5 10 5-10 5L2 9Z" />
                <path d="M6 11v4.5c3.5 2.5 8.5 2.5 12 0V11M22 9v5" />
            </svg>
            สาขาวิชา
        </a>
    </nav>

    <main class="content-panel">

    <?php

    if ($page === 'student') {

        $controller = new StudentController();
        $controller->index();

    } elseif ($page === 'major') {

        $controller = new MajorController();
        $controller->index();

    } else {

        echo "<h2>ไม่พบหน้าที่ต้องการ</h2>";

    }

    ?>

    </main>

</div>

</body>
</html>
