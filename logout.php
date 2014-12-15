<?php

session_start();
unset($_SESSION['id']);
unset($_SESSION['password']);
session_destroy();
ldap_unbind($ldapconn);
header("Location: index.php");

?>
