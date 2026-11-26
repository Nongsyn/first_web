<section class="page-heading">
    <div>
        <p class="eyebrow">STUDENT DIRECTORY</p>
        <h2>ข้อมูลนักเรียน</h2>
        <p class="page-description">รายชื่อและข้อมูลติดต่อของนักเรียนทั้งหมด</p>
    </div>
    <div class="record-count">
        <span class="count-dot" aria-hidden="true"></span>
        <?= count($students ?? []) ?> คน
    </div>
</section>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th scope="col">รหัส</th>
                <th scope="col">ชื่อ-นามสกุล</th>
                <th scope="col">สาขาวิชา</th>
                <th scope="col">เบอร์โทรศัพท์</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td>
                            <span class="id-badge"><?= htmlspecialchars((string)($student['id'] ?? '')) ?></span>
                        </td>
                        <td><?= htmlspecialchars((string)($student['stdname'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($student['major'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($student['tel'] ?? '')) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="empty-row">
                    <td colspan="4">ยังไม่มีข้อมูลนักเรียน</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
