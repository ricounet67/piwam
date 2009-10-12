<?php
/*
 * Required parameter :
 *
 * $error
 */
?>

<?php if ($error): ?>

    <strong>
        Extension <span style="font-family: courier">php_smtp</span> : absente
    </strong><br />

    Attention. Sans cette extension, vous ne pourrez pas envoyer d'e-mails en
    utilisant un serveur SMTP.<br />
    Ouvrez votre fichier <span style="font-family: courier">php.ini</span> et
    vérifiez que l'extension <span style="font-family: courier">php_smtp</span>
    est chargée.

<?php else: ?>

    L'extension <span style="font-family: courier">php_smtp</span> est
    correctement lancée

<?php endif; ?>