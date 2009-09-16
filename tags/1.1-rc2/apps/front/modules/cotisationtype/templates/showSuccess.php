<table>
    <tbody>
        <tr>
            <th>Id:</th>
            <td><?php echo $cotisation_type->getId() ?></td>
        </tr>
        <tr>
            <th>Libelle:</th>
            <td><?php echo $cotisation_type->getLibelle() ?></td>
        </tr>
        <tr>
            <th>Valide:</th>
            <td><?php echo $cotisation_type->getValide() ?></td>
        </tr>
        <tr>
            <th>Montant:</th>
            <td><?php echo $cotisation_type->getMontant() ?></td>
        </tr>
        <tr>
            <th>Actif:</th>
            <td><?php echo $cotisation_type->getActif() ?></td>
        </tr>
        <tr>
            <th>Created at:</th>
            <td><?php echo $cotisation_type->getCreatedAt() ?></td>
        </tr>
        <tr>
            <th>Updated at:</th>
            <td><?php echo $cotisation_type->getUpdatedAt() ?></td>
        </tr>
    </tbody>
</table>

<hr />

<a
    href="<?php echo url_for('cotisationtype/edit?id='.$cotisation_type->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('cotisationtype/index') ?>">List</a>
