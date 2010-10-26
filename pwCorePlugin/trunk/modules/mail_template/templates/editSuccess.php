<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/* 
 * Input :
 *    MailTemplateForm $form
 *    MailTemplate $template
 *    Collection MailTemplateVariable $templateVariables
 */
use_helper('Date');
use_javascript('/pwCorePlugin/js/tiny_mce/tiny_mce.js') 
?>

<div class="global_errors">
  <?php echo $form->renderGlobalErrors() ?>
</div>

<form
  method="POST"
  action="<?php echo url_for('@mail_template_update?id='.$form->getObject()->getId()) ?>">

  <input type="hidden" name="sf_method" value="put" />

  <table class="formtable">
    <tfoot>
      <tr>
        <th>&nbsp;</th>
        <td><?php echo link_to('Annuler', '@mail_templates_list', array('class' => 'blue button')) ?>
        		<input type="submit" value="Sauvegarder" class="button blue" /></td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderHiddenFields() ?>
      <tr>
      	<th>Identifiant</th>
      	<td><?php echo $template->getTemplateKey() ?></td>
      </tr>
      <tr>
      	<th>Description</th>
      	<td><?php echo $template->getDescription() ?></td>
      </tr>
      <tr>
      	<th>Dernière modification </th>
      	<td><?php echo format_date($template->getUpdatedAt()) ?></td>
      </tr>
      <tr>
      	<th>Variables utilisables</th>
      	  <td><?php if(count($templateVariables) > 0): ?>
	      		<table class="datalist">
		      		<tbody>
		      		<?php foreach($templateVariables as $variable): ?>
		      			<tr><td style="border: none;"><?php echo $variable->getVariableKey() . ' : ' ?></td>
		      				<td style="border: none;"><?php echo $variable->getDescription() ?></td></tr>
		      		<?php endforeach ?>
		      		</tbody>
	      		</table>  		
      		<?php else: ?>
      			Aucune
      		<?php endif ?>
      	</td>
      </tr>
      <tr>
        <th><?php echo $form['subject']->renderLabel() ?></th>
        <td><?php echo $form['subject'] . $form['subject']->renderError() ?></td>
      </tr>
      <tr>
        <th><?php echo $form['content']->renderLabel() ?></th>
        <td><?php echo $form['content'] . $form['content']->renderError() ?></td>
      </tr>
    </tbody>
  </table>
</form>
