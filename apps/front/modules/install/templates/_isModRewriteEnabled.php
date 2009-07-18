<?php
/*
 * Required parameters :
 *
 * $error
 */
?>

<?php if ($error): ?>
	Le module Apache mod_rewrite n'est pas activé
<?php else: ?>
	Le module Apache mod_rewrite est activé
<?php endif; ?>