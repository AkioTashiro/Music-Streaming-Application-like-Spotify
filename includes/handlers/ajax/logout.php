<!--to logout-->

<?php  
session_start();  //need to start bc there is nothing to destroy.
session_destroy();  //how we logout
?>