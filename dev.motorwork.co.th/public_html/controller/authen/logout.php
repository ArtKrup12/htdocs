<?php
session_start();
session_unset();
session_destroy();
?>
<script>
    localStorage.removeItem('page');
    localStorage.clear();
    window.location.href = '/login';
</script>
