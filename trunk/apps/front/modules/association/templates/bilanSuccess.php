<?php use_helper('Number') ?>

<h2>Bilan</h2>

<?php 
// Even if it's not really MVC compliant, we compute the total
// amount of Recette / Depense line by line directly within
// this view
$totalDepenses	= 0;
$totalRecettes	= 0;
$total			= 0;
?>


<h3>Par compte</h3>
<table class="tableauDonnees">
	<thead>
		<tr class="enteteTableauDonnees">
			<th width="60%">Compte</th>
			<th width="10%">Dépenses</th>
			<th width="10%">Recettes</th>
			<th width="10%">Bilan</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($comptes as $compte): ?>
	
		<tr <?php
				if ($compte->isNegative()) {
					echo 'class="compteNegatif"';
				}
				else { 
					echo 'class="comptePositif"';
				}
			?>>
			<td><?php echo $compte->getReference() ?></td>
			<td><?php echo format_currency($compte->getTotalDepenses()); $totalDepenses += $compte->getTotalDepenses() ?></td>
			<td><?php echo format_currency($compte->getTotalRecettes()); $totalRecettes += $compte->getTotalRecettes() ?></td>
			<td><?php echo format_currency($compte->getTotal()); $total += $compte->getTotal() ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr <?php 
			if ($total < 0) {
				echo 'class="compteNegatif"';
			}
			else {
				echo 'class="comptePositif"';
			}
		?>>
			<td><strong>TOTAL</strong></td>
			<td><?php echo $totalDepenses ?></td>
			<td><?php echo $totalRecettes ?></td>
			<td><?php echo $total ?></td>
		</tr>
	</tfoot>
</table>



<h3>Par activité</h3>

<?php 
// We re-initialize our counters
$totalDepenses	= 0;
$totalRecettes	= 0;
$total			= 0;
?>

<table class="tableauDonnees">
	<thead>
		<tr class="enteteTableauDonnees">
			<th width="60%">Activité</th>
			<th width="10%">Dépenses</th>
			<th width="10%">Recettes</th>
			<th width="10%">Bilan</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($activites as $activite): ?>
		<tr <?php
				if ($activite->getTotal() < 0) {
					echo 'class="compteNegatif"';
				}
				else { 
					echo 'class="comptePositif"';
				}
			?>>
			<td><?php echo $activite->getLibelle() ?></td>
			<td><?php echo format_currency($activite->getTotalDepenses()); $totalDepenses += $activite->getTotalDepenses() ?></td>
			<td><?php echo format_currency($activite->getTotalRecettes()); $totalRecettes += $activite->getTotalRecettes() ?></td>
			<td><?php echo format_currency($activite->getTotal()); $total += $activite->getTotal() ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr <?php
				if ($total < 0) {
					echo 'class="compteNegatif"';
				}
				else { 
					echo 'class="comptePositif"';
				}
			?>>
			<td><strong>TOTAL</strong></td>
			<td><?php echo $totalDepenses ?></td>
			<td><?php echo $totalRecettes ?></td>
			<td><?php echo $total ?></td>	
		</tr>
	</tfoot>
</table>
