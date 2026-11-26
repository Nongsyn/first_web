<?php
    foreach ($majors ?? [] as $row) {
        echo $row['id'];
        echo $row['stdname'];
        echo $row['major'];
        echo $row['tel'];
    }
?>