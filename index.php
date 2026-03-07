<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-03 09:18:02
 */
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: pages/login.php");
    exit;
}

header("Location: pages/list_customers.php");
exit;
