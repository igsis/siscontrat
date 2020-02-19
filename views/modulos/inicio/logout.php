<?php
(new MainModel())->gravarLog("Fez Logout");
session_destroy();
?>
<script>
    window.location.href = "<?= SERVERURL ?>";
</script>