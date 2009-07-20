<?php
/*
 * Required parameters :
 *
 * $error
 */
?>

<?php if ($error): ?>
	Le fichier config/databases.yml n'est pas inscriptible
<?php else: ?>
	Le fichier config/databases.yml est inscriptible
<?php endif; ?>