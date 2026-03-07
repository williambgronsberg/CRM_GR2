<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-03 09:18:02
 */
require "pages/auth/auth.php";

if (!isLoggedIn()) {
    header("Location: pages/login.php");
    exit;
}

header("Location: pages/list_customers.php");
exit;
