<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06 15:54:09
 * @Last Modified by:   William Berge Groensberg
 * @Last Modified time: 2026-03-06 15:54:19
 */


session_start();

if (!isset($_SESSION["username"])) {
	header("Location: ../index.php");
	exit;
}
