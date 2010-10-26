<h2>Gestion des groupes de droits</h2>

<table class="datalist">
    <thead>
        <tr>
            <th width="20%">Nom</th>
            <th width="50%">Description</th>
            <th width="12%">Nombre de droits</th>
            <th width="12%">Nombre de membres</th>
            <th class="actions">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($aclGroups as $aclGroup): ?>
           <tr>
           		<td><?php echo $aclGroup->getLabel() ?></td>
           		<td><?php echo $aclGroup->getDescription() ?></td>
           		<td><?php echo $aclGroup->getNbPermissions() . ' / ' . $nbAclActions ?></td>
           		<td><?php echo $aclGroup->getNbUsers() ?></td>
           		<td>
        			<?php echo link_to(image_tag('/pwCorePlugin/images/icons/edit',   
        					array('alt' => '[modifier]')),  '@acl_group_edit?id=' . $aclGroup->getId())?>
        			<?php echo link_to(image_tag('/pwCorePlugin/images/icons/delete', 
        					array('alt' => '[supprimer]')), '@acl_group_delete?id=' . $aclGroup->getId(), 
        					array('method' => 'delete', 'confirm' => 'Etes vous sûr ?')) ?>
    			</td>
           </tr>
        <?php endforeach ?>
    </tbody>
</table>

<br />
<?php echo link_to('Nouveau groupe', '@acl_group_new', array('class' => 'add grey button')) ?>