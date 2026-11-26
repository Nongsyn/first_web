
<h2>ข้อมูลสาขาวิชา (Major)</h2>

<table>
    <thead>
        <tr>
            <th>ชื่อสาขาวิชา</th>
        </tr>
    </thead>

    <tbody>

        <?php if (!empty($majors)): ?>

            <?php foreach ($majors as $major): ?>

                <tr>
                    <td>
                        <?= htmlspecialchars((string)($major['Major'] ?? '')) ?>
                    </td>
                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td>ยังไม่มีข้อมูลสาขาวิชา</td>
            </tr>

        <?php endif; ?>

    </tbody>
</table>
