<?php
session_start();

class Student
{
    public string $stdid;
    public string $stdname;
    public int $age;
    public string $department;
    public float $gpa;
    public string $advisor;
    public string $phone;
    public string $room;
    public string $address;

    public function __construct(string $stdid, string $stdname, int $age, string $department, float $gpa, string $advisor, string $phone, string $room, string $address)
    {
        $this->stdid = $stdid;
        $this->stdname = $stdname;
        $this->age = $age;
        $this->department = $department;
        $this->gpa = $gpa;
        $this->advisor = $advisor;
        $this->phone = $phone;
        $this->room = $room;
        $this->address = $address;
    }

    public function getStudentInfo(): string
    {
        return "รหัสนักศึกษา: {$this->stdid}\nชื่อ: {$this->stdname}\nอายุ: {$this->age}\nแผนกวิชา: {$this->department}\nเกรดเฉลี่ย: {$this->gpa}\nครูที่ปรึกษา: {$this->advisor}\nเบอร์: {$this->phone}\nห้อง: {$this->room}\nที่อยู่: {$this->address}";
    }
}

$defaultStudent = new Student("69319010001", "นายศุภกร แรงเขตกิจ", 19, "เทคโนโลยีสารสนเทศ", 3.75, "นางสาวสมคิด หวังดี", "081-234-5678", "A-305", "123/45 ถนนสยาม แขวงบางรัก กรุงเทพมหานคร");
$submittedStudent = $_SESSION['submitted_student'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_student'])) {
        unset($_SESSION['submitted_student']);
        $submittedStudent = null;
    } elseif (isset($_POST['stdid'])) {
        $stdid = trim($_POST['stdid']);
        $stdname = trim($_POST['stdname']);
        $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);
        $department = trim($_POST['department'] ?? '');
        $gpa = filter_var($_POST['gpa'] ?? '', FILTER_VALIDATE_FLOAT);
        $advisor = trim($_POST['advisor'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $room = trim($_POST['room'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if ($stdid !== '' && $stdname !== '' && $age !== false && $age >= 1 && $age <= 100 && $department !== '' && $gpa !== false && $gpa >= 0 && $gpa <= 4 && $advisor !== '' && $phone !== '' && strlen($phone) <= 10 && preg_match('/^[0-9]+$/', $phone) && $room !== '' && $address !== '') {
            $submittedStudent = new Student($stdid, $stdname, $age, $department, $gpa, $advisor, $phone, $room, $address);
            $_SESSION['submitted_student'] = $submittedStudent;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <style>
        :root {
            --bg: #020817;
            --panel: rgba(10, 17, 30, 0.88);
            --panel-strong: rgba(13, 20, 34, 0.96);
            --primary: #7c3aed;
            --secondary: #22d3ee;
            --text: #e6f3ff;
            --muted: #8ea6c7;
            --line: rgba(110, 231, 255, 0.18);
        }

        * { box-sizing: border-box; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulseGlow {
            0%, 100% {
                box-shadow: 0 0 0 rgba(124, 58, 237, 0.35);
            }
            50% {
                box-shadow: 0 0 24px rgba(34, 211, 238, 0.26);
            }
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background:
                linear-gradient(rgba(15, 23, 42, 0.55), rgba(2, 8, 23, 0.92)),
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.4), transparent 32%),
                radial-gradient(circle at bottom right, rgba(34, 211, 238, 0.28), transparent 26%),
                var(--bg);
            color: var(--text);
            display: grid;
            place-items: center;
            padding: 32px 20px;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(34, 211, 238, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(34, 211, 238, 0.05) 1px, transparent 1px),
                radial-gradient(circle, rgba(255,255,255,0.75) 1px, transparent 1.6px);
            background-size: 38px 38px, 38px 38px, 14px 14px;
            opacity: 0.4;
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: "";
            position: fixed;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
            top: 10%;
            left: 8%;
            background: rgba(124, 58, 237, 0.22);
            animation: pulseGlow 5s ease-in-out infinite;
            box-shadow: 0 0 60px rgba(124, 58, 237, 0.2);
        }

        .card {
            position: relative;
            z-index: 1;
            width: min(100%, 760px);
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid rgba(34, 211, 238, 0.22);
            border-radius: 28px;
            box-shadow: 0 0 0 1px rgba(148, 163, 184, 0.12), 0 24px 55px rgba(2, 6, 23, 0.5), 0 0 26px rgba(124, 58, 237, 0.2);
            backdrop-filter: blur(12px);
            overflow: hidden;
            animation: fadeInUp 0.7s ease-out both;
        }

        .header {
            padding: 26px 32px 18px;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.16), rgba(34, 211, 238, 0.1));
            animation: fadeInUp 0.9s ease-out 0.1s both;
            box-shadow: inset 0 -1px 0 rgba(34, 211, 238, 0.1);
        }

        h1 {
            margin: 0;
            font-size: clamp(2rem, 4vw, 2.8rem);
            letter-spacing: -0.05em;
        }

        .content {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 0;
        }

        form {
            padding: 28px;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.42), rgba(15, 23, 42, 0.72));
            border: 1px solid rgba(34, 211, 238, 0.12);
            border-radius: 24px;
        }

        .form-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 0 0 22px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.14);
            font-size: 1.2rem;
            letter-spacing: 0.04em;
            color: #dbeafe;
        }

        .form-header::after {
            content: "STUDENT INFO";
            font-size: 0.72rem;
            letter-spacing: 0.18em;
            color: rgba(34, 211, 238, 0.8);
            text-transform: uppercase;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 14px 14px 12px;
            border: 1px solid rgba(148, 163, 184, 0.12);
            border-radius: 16px;
            background: rgba(10, 15, 26, 0.52);
            animation: fadeInUp 0.75s ease-out both;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 0.02em;
        }

        input,
        textarea {
            width: 100%;
            border: 1px solid rgba(148, 163, 184, 0.16);
            background: rgba(15, 23, 42, 0.9);
            color: var(--text);
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 1rem;
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
            font-family: inherit;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: rgba(34, 211, 238, 0.7);
            box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.12);
            transform: translateY(-1px);
        }

        .submit-wrap {
            margin-top: 22px;
            display: flex;
            justify-content: flex-end;
        }

        button {
            border: none;
            border-radius: 14px;
            padding: 14px 22px;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 18px 30px rgba(124, 58, 237, 0.35), 0 0 18px rgba(34, 211, 238, 0.18);
            cursor: pointer;
            transition: transform 0.22s ease, box-shadow 0.22s ease, filter 0.22s ease;
            animation: pulseGlow 3.2s ease-in-out infinite;
        }

        button:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 20px 34px rgba(124, 58, 237, 0.42), 0 0 20px rgba(34, 211, 238, 0.2);
            filter: brightness(1.06);
        }

        .info {
            padding: 32px 24px;
            border-left: 1px solid var(--line);
            background: rgba(9, 15, 27, 0.9);
        }

        .profile {
            padding: 18px 20px;
            background: rgba(124, 58, 237, 0.12);
            border-radius: 20px;
            border: 1px solid rgba(34, 211, 238, 0.25);
            box-shadow: inset 0 0 18px rgba(124, 58, 237, 0.18), 0 0 18px rgba(34, 211, 238, 0.12);
        }

        .profile h2 {
            margin: 0 0 10px;
            font-size: 1.2rem;
        }

        .profile p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .delete-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 16px;
            border: 1px solid rgba(248, 113, 113, 0.45);
            background: rgba(127, 29, 29, 0.18);
            color: #fecaca;
            border-radius: 10px;
            padding: 10px 14px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .delete-btn:hover {
            transform: translateY(-1px);
            opacity: 0.96;
        }

        @media (max-width: 720px) {
            .content {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .info {
                border-left: none;
                border-top: 1px solid var(--line);
            }

            form {
                padding: 22px 18px 28px;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>Student Dashboard</h1>
        </div>

        <div class="content">
            <form method="POST" action="">
                <h2 class="form-header">ข้อมูลนักศึกษา</h2>
                <div class="form-grid">
                    <div class="field">
                        <label for="stdid">รหัสนักศึกษา</label>
                        <input type="number" id="stdid" name="stdid" placeholder="กรอกรหัสนักศึกษา" required>
                    </div>

                    <div class="field">
                        <label for="stdname">ชื่อนักศึกษา</label>
                        <input type="text" id="stdname" name="stdname" placeholder="กรอกชื่อนักศึกษา" required>
                    </div>

                    <div class="field">
                        <label for="age">อายุ</label>
                        <input type="number" id="age" name="age" placeholder="กรอกอายุ" min="1" max="100" required>
                    </div>

                    <div class="field">
                        <label for="department">แผนกวิชา</label>
                        <input type="text" id="department" name="department" placeholder="กรอกแผนกวิชา" required>
                    </div>

                    <div class="field">
                        <label for="gpa">เกรดเฉลี่ย</label>
                        <input type="number" id="gpa" name="gpa" placeholder="กรอกเกรดเฉลี่ย" min="0" max="4" step="0.01" required>
                    </div>

                    <div class="field">
                        <label for="advisor">ครูที่ปรึกษา</label>
                        <input type="text" id="advisor" name="advisor" placeholder="กรอกชื่อครูที่ปรึกษา" required>
                    </div>

                    <div class="field">
                        <label for="phone">เบอร์</label>
                        <input type="tel" id="phone" name="phone" placeholder="กรอกเบอร์โทร" maxlength="10" pattern="[0-9]{10}" required>
                    </div>

                    <div class="field">
                        <label for="room">ห้อง</label>
                        <input type="text" id="room" name="room" placeholder="กรอกห้องเรียน" required>
                    </div>

                    <div class="field full">
                        <label for="address">ที่อยู่</label>
                        <textarea id="address" name="address" rows="3" placeholder="กรอกที่อยู่" required></textarea>
                    </div>
                </div>

                <div class="submit-wrap">
                    <button type="submit">บันทึกข้อมูล</button>
                </div>
            </form>

            <aside class="info">
                <div class="profile">
                    <h2>Latest profile</h2>
                    <p>
                        <?php
                            if ($submittedStudent instanceof Student) {
                                echo nl2br(htmlspecialchars($submittedStudent->getStudentInfo(), ENT_QUOTES, 'UTF-8'));
                            } else {
                                echo nl2br(htmlspecialchars($defaultStudent->getStudentInfo(), ENT_QUOTES, 'UTF-8'));
                            }
                        ?>
                    </p>

                    <?php if ($submittedStudent instanceof Student): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="delete_student" value="1">
                            <button type="submit" class="delete-btn">ลบข้อมูลที่เพิ่ม</button>
                        </form>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>