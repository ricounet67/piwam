<?php use_helper('Date') ?>
<?php use_helper('Membre') ?>
<?php use_helper('Number') ?>

<h2>Détails pour "<?php echo $activite->getLibelle() ?>"</h2>

<table class="tableauDetails">
  <tbody>
    <tr>
      <th><?php echo image_tag('time.png', 'align="absmiddle"')?> Enregistrée le :</th>
      <td><?php echo format_datetime($activite->getCreatedAt(), 'dd/MM/yyyy HH:mm') ?> par <?php echo format_membre($activite->getMembreRelatedByEnregistrePar()) ?></td>
    </tr>
    <tr>
      <th><?php echo image_tag('time.png', 'align="absmiddle"')?> Mise à jour le :</th>
      <td><?php echo format_datetime($activite->getUpdatedAt(), 'dd/MM/yyyy HH:mm') ?> par <?php echo format_membre($activite->getMembreRelatedByMisAJourPar())?></td>
    </tr>
  </tbody>
</table>


<h3>Recettes et dépenses</h3>

<?php
$totalRecettes = 0;
$totalDepenses = 0;
?>

<table class="tableauDonnees">
	<thead>
		<tr class="enteteTableauDonnees">
			<th>Libellé</th>
			<th>Débit</th>
			<th>Crédit</th>
			<th>Date</th>
		</tr>
	</thead>

	<?php foreach ($data as $entry): ?>
	<tr>
		<td><?php echo $entry->getLibelle() ?></td>
		<?php if ($entry->getRawValue() instanceof Depense):?>
			<td class="compteNegatif"><?php echo format_currency($entry->getMontant()); $totalDepenses += $entry->getMontant() ?></td>
			<td>&nbsp;</td>
		<?php else: ?>
			<td>&nbsp;</td>
			<td class="comptePositif"><?php echo format_currency($entry->getMontant()); $totalRecettes += $entry->getMontant() ?></td>
		<?php endif; ?>
		<td><?php echo format_date($entry->getDate()) ?></td>
	</tr>
	<?php endforeach; ?>

	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr class="<?php echo ($totalRecettes - $totalDepenses < 0) ? 'compteNegatif' : 'comptePositif'; ?>">
		<td><strong>Total</strong></td>
		<td><?php echo format_currency($totalDepenses); ?></td>
		<td><?php echo format_currency($totalRecettes); ?></td>
		<td><?php echo format_currency($totalRecettes - $totalDepenses) ?></td>
	</tr>
</table>
