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
			<th>Compte</th>
			<th>Dépenses</th>
			<th>Recettes</th>
			<th>Bilan</th>
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
			<td><?php echo $compte->getTotalDepenses(); $totalDepenses += $compte->getTotalDepenses() ?></td>
			<td><?php echo $compte->getTotalRecettes(); $totalRecettes += $compte->getTotalRecettes() ?></td>
			<td><?php echo $compte->getTotal(); $total += $compte->getTotal() ?></td>
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
			<td>TOTAL</td>
			<td><?php echo $totalDepenses ?></td>
			<td><?php echo $totalRecettes ?></td>
			<td><?php echo $total ?></td>
		</tr>
	</tfoot>
</table>

<h3>Par activité</h3>

<table class="tableauDonnees">
	<thead>
		<tr class="enteteTableauDonnees">
			<th>Activité</th>
			<th>Dépenses</th>
			<th>Recettes</th>
			<th>Bilan</th>
		</tr>
	</thead>
</table>
