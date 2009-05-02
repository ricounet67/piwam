<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<form action="<?php echo url_for('association/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table class="formArray">
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields() ?>
          <?php echo link_to('Annuler', 'membre/index', array(
          	'class'	=> 'formLinkButton'
          )) ?>
          
          <?php if (!$form->getObject()->isNew()): ?>
            <?php echo link_to('Supprimer', 'association/delete?id='.$form->getObject()->getId(), array(
            	'class'		=> 'formLinkButton',
          		'method' 	=> 'delete', 'confirm' => 'Etes vous sûr ?'
            )) ?>
          <?php endif; ?>
          
          <?php if ($form->getObject()->isNew()): ?>
	          	<input type="submit" value="Étape suivante >" class="button" />
	      <?php else: ?>
	      		<input type="submit" value="Sauvegarder" class="button" />
	      <?php endif; ?>
        </td>
      </tr>
    </tfoot>
    <tbody>
    	<tr>
    		<td colspan="2">    			
    			<?php 
    			if ($form->hasGlobalErrors())
    			{
    				echo '<div class="error">' . $form->renderGlobalErrors() . '</div>';
    			}
    			?>
    		</td>
      	</tr>
      <tr>
        <th>Nom de l'association :</th>
        <td>
          <?php echo $form['nom'] ?>
          <?php echo $form['nom']->renderError() ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['description']->renderLabel() ?></th>
        <td>
          <?php echo $form['description'] ?>
          <?php echo $form['description']->renderError() ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['site_web']->renderLabel() ?></th>
        <td>
          <?php echo $form['site_web'] ?>
          <?php echo $form['site_web']->renderError() ?>
        </td>
      </tr>
      
    </tbody>
  </table>
</form>
