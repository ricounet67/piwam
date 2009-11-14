<?php
/*
 * Required parameters :
 *
 * $error
 */
?>

<?php if ($error): ?>

    <strong>
        Répertoire non inscriptible
    </strong><br />

    Le répertoire <span style="font-family: courier">web/uploads/trombinoscope</span> n'est
    pas inscriptible

<?php else: ?>

    Le répertoire <span style="font-family: courier">web/uploads/trombinoscope</span> est inscriptible

<?php endif; ?>
