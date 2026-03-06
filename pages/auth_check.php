<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06 15:52:28
 * @Last Modified by:   William Berge Groensberg
 * @Last Modified time: 2026-03-06 15:54:47
 */


session_start();

if (!isset($_SESSION["username"])) {
	header("Location: ../index.php");
	exit;
}
