<?php use_helper('Date') 	?>
<?php use_helper('Membre') 	?>
<?php use_helper('Boolean') ?>
<?php use_helper('Javascript') ?>

<h2>Informations détaillées &nbsp; <?php echo link_to(image_tag('edit'), 'membre/edit?id='.$membre->getId()) ?></h2>

<table class="tableauDetails" id="details">
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
            <td><?php echo format_date($membre->getDateInscription()) ?></td>
        </tr>
        <tr>
            <th>Exempté de cotisation :</th>
            <td><?php echo boolean2icon($membre->getExempteCotisation()) ?></td>
        </tr>
        <tr>
            <th>Adresse :</th>
            <td><?php echo $membre->getRue() . '<br />' . $membre->getCp() . ' ' . $membre->getVille() ?></td>
        </tr>
        <tr>
            <th>Pays :</th>
            <td><?php echo image_tag('flags/' . strtolower($membre->getPays()), array('alt' => $membre->getPays(), 'title' => $membre->getPays())) ?></td>
        </tr>
        <tr>
            <th>Email :</th>
            <td><?php echo '<a href="' . $membre->getEmail() . '">' . $membre->getEmail() . '</a>' ?></td>
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
            <td><?php echo boolean2icon($membre->getActif()) ?></td>
        </tr>
        <tr>
            <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?> Enregistré le :</th>
            <td><?php echo format_datetime($membre->getCreatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_membre($membre->getMembreRelatedByEnregistrePar()) ?></td>
        </tr>
        <tr>
            <th><?php echo image_tag('time.png', array('align' => 'absmiddle', 'alt' => 'Time'))?> Dernière édition :</th>
            <td><?php echo format_datetime($membre->getUpdatedAt(), 'dd/MM/yyyy HH:mm') . ' par ' . format_membre($membre->getMembreRelatedByMisAJourPar()) ?></td>
        </tr>
    </tbody>
</table>

<hr />
&nbsp;
<a href="<?php echo url_for('membre/index') ?>">Retour</a>

<br />
<h2>Liste des cotisations <?php echo image_tag('arrow_down', 'align="absmiddle"') ?></h2>
<div id="listOfCotisation" class="info">
	<div>
		<ul>
			<?php if (count($cotisations) == 0): ?>
				<li><i>Aucune cotisation versée par ce membre.</i></li>
			<?php endif; ?>

			<?php foreach ($cotisations as $cotisation): ?>
				<li><?php echo $cotisation->getCotisationType() ?> versée le <?php echo $cotisation->getDate() ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>