<?php
/*
 * Required parameter :
 *
 * $error
 */
?>

<?php if ($error): ?>

    <strong>
        <span style="font-family: courier">memory_limit</span> &lt;= 32M
    </strong><br />

    Si le paramètre <span style="font-family: courier">memory_limit</span> est
    inférieur à 32M, Piwam pourra fonctionner mais le fonctionnement pourra
    être différent.

<?php else: ?>

    Le paramètre <span style="font-family: courier">memory_limit</span> est
    supérieur à 32M

<?php endif; ?>