
<?php use_javascripts_for_form($form) ?>
<?php use_stylesheets_for_form($form) ?>

<script type="text/javascript">
	//sfMediaBrowserWindowManager.init('<?php //echo url_for('sf_media_browser_select') ?>');
</script>

<form
  action="<?php echo url_for('@event_'.($form->getObject()->isNew() ? 'create' : 'update?id='.$form->getObject()->getId())) ?>"
  method="post"><?php if (!$form->getObject()->isNew()): ?> <input
  type="hidden" name="sf_method" value="put" /> <?php endif ?>


<table class="formtable" summary="Register a event">
  <tfoot>
    <tr>
      <td colspan="2"><?php echo $form->renderHiddenFields() ?> <?php echo link_to('Annuler', '@events_list', array('class'	=> 'blue button')) ?>

      <input type="submit" value="Sauvegarder" class="blue button" /></td>
    </tr>
  </tfoot>
  <tbody>
  <?php echo $form->renderGlobalErrors() ?>
  <?php echo $form ?>
  </tbody>
</table>
</form>
