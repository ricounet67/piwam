<?php use_helper('Date') ?>
<?php use_helper('Number') ?>

<h2>Gestion des dépenses</h2>

<table class="tableauDonnees">
    <thead>
        <tr class="enteteTableauDonnees">
            <th>Libellé</th>
            <th>Montant</th>
            <th>Compte</th>
            <th>Activité</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($depense_list as $depense): ?>
        <tr>
            <td><?php echo $depense->getLibelle() ?></td>
            <td><?php echo format_currency($depense->getMontant()) ?></td>
            <td><?php echo $depense->getCompte() ?></td>
            <td><?php echo $depense->getActivite() ?></td>
            <td><?php echo format_date($depense->getDate()) ?></td>
            <td>
                <a href="<?php echo url_for('depense/show?id=' . $depense->getId()) ?>"><?php echo image_tag('details.png') ?></a>
                <a href="<?php echo url_for('depense/edit?id=' . $depense->getId()) ?>"><?php echo image_tag('edit.png') ?></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?php echo url_for('depense/new') ?>">Enregistrer une nouvelle dépense</a>
