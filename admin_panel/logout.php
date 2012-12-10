<?php include 'admin_session.php';

session_destroy();

echo("<script>location.href=\"login.php\"</script>");

?>
