<?php
/*
 * Required parameter :
 *
 * $error
 */
?>

<?php if ($error): ?>
	Le paramètre memory_limit n'est pas supérieur à 128M
<?php else: ?>
	Le paramètre memory_limit est supérieur à 128M
<?php endif; ?>