<table>
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
            <th>Cotisation type:</th>
            <td><?php echo $due->getDueTypeId() ?></td>
        </tr>
        <tr>
            <th>Membre:</th>
            <td><?php echo $due->getMember() ?></td>
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

<hr />

<a href="<?php echo url_for('cotisation/edit?id='.$due->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('cotisation/index') ?>">List</a>
