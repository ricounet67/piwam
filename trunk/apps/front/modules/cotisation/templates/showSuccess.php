<?php use_helper('Membre') ?>

<h2>Détails d'une cotisation</h2>

<table class="details">
    <tbody>
        <tr>
            <th>Id:</th>
            <td><?php echo $due->getId() ?></td>
        </tr>
        <tr>
            <th>Compte:</th>
            <td><?php echo $due->getAccount() ?></td>
        </tr>
        <tr>
            <th>Cotisation type :</th>
            <td><?php echo $due->getDueType() ?></td>
        </tr>
        <tr>
            <th>Montant :</th>
            <td><?php echo $due->getAmount() ?></td>
        </tr>
        <tr>
            <th>Membre:</th>
            <td><?php echo format_member($due->getMember()) ?></td>
        </tr>
        <tr>
            <th>Date:</th>
            <td><?php echo $due->getDate() ?></td>
        </tr>
        <tr>
            <th>Created at:</th>
            <td><?php echo $due->getCreatedAt() ?></td>
        </tr>
        <tr>
            <th>Updated at:</th>
            <td><?php echo $due->getUpdatedAt() ?></td>
        </tr>
    </tbody>
</table>

<a href="<?php echo url_for('@due_edit?id='.$due->getId()) ?>">Éditer</a>
&bull;
<a href="<?php echo url_for('@dues_list') ?>">Retour à la liste</a>
