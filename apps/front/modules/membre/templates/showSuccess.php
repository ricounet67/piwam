<?php use_helper('Date'); ?>
<?php use_helper('Membre'); ?>

<h2>Informations détaillées</h2>

<table class="tableauDetails">
    <tbody>
        <tr>
            <th>Nom :</th>
            <td><?php echo $membre->getNom() ?></td>
        </tr>
        <tr>
            <th>Prénom :</th>
            <td><?php echo $membre->getPrenom() ?></td>
        </tr>
        <tr>
            <th>Pseudo :</th>
            <td><?php echo $membre->getPseudo() ?></td>
        </tr>
        <tr>
            <th>Statut :</th>
            <td><?php echo $membre->getStatut() ?></td>
        </tr>
        <tr>
            <th>Date d'inscription :</th>
            <td><?php echo $membre->getDateInscription() ?></td>
        </tr>
        <tr>
            <th>Exempté de cotisation :</th>
            <td><?php echo $membre->getExempteCotisation() ?></td>
        </tr>
        <tr>
            <th>Adresse :</th>
            <td><?php echo $membre->getRue() . '<br />' . $membre->getCp() . ' ' . $membre->getVille() ?></td>
        </tr>
        <tr>
            <th>Pays:</th>
            <td><?php echo $membre->getPays() ?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><?php echo $membre->getEmail() ?></td>
        </tr>
        <tr>
            <th>Site Internet :</th>
            <td><?php echo '<a href="' . $membre->getWebsite() . '">' . $membre->getWebsite() . '</a>' ?></td>
        </tr>
        <tr>
            <th>Téléphone fixe :</th>
            <td><?php echo $membre->getTelfixe() ?></td>
        </tr>
        <tr>
            <th>Téléphone portable :</th>
            <td><?php echo $membre->getTelportable() ?></td>
        </tr>
        <tr>
            <th>Actif :</th>
            <td><?php echo $membre->getActif() ?></td>
        </tr>
        <tr>
            <th>Enregistré le :</th>
            <td><?php echo format_datetime($membre->getCreatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_membre($membre->getMembreRelatedByEnregistrePar()) ?></td>
        </tr>
        <tr>
            <th>Dernière édition :</th>
            <td><?php echo format_datetime($membre->getUpdatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_membre($membre->getMembreRelatedByMisAJourPar()) ?></td>
        </tr>
    </tbody>
</table>

<hr />

<a href="<?php echo url_for('membre/edit?id='.$membre->getId()) ?>">Editer</a>
&nbsp;
<a href="<?php echo url_for('membre/index') ?>">Retour</a>
