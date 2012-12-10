<?php include 'admin_session.php';

//remove the session cookie
session_destroy();

echo("<script>location.href=\"login.php\"</script>");

?>
