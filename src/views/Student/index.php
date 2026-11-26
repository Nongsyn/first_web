<?php
    foreach ($students ?? [] as $row) {
        echo $row['id'];
        echo $row['stdname'];
        echo $row['major'];
        echo $row['tel'];
    }
?>