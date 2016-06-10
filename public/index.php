<?php

require_once '../config/path.php';
require_once BASE_PATH . 'config/db.php';
require_once BASE_PATH . 'CommentSystem/bootstrap.php';

$commentSystemApp = new CommentSystem\App;

$commentSystemApp->run();

?>