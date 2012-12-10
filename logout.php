<?php include 'session.php';

//destroy the session cookie to log out
session_destroy();

//return to front page
echo("<script>location.href=\"index.php\"</script>");

?>
