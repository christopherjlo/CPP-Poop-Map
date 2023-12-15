<?php
session_start();
unset($_SESSION["currentID"]);
session_destroy();

header("Location: index.html");
