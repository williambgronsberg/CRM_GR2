<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06 15:52:28
 */

session_start();

if (!isset($_SESSION["username"])) {
	header("Location: ../index.php");
	exit;
}
