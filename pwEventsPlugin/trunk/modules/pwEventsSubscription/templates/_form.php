<?php use_helper('jQuery') ?>
<?php //jq_add_plugins_by_name(array('ui')) ?>

<style>
</style>
<script>
jQuery().ready(function()
{
  // init state
  probabilityOptions(jQuery(".choice_probability:checked").val());

  jQuery(".choice_probability").change(function (){
    probabilityOptions(jQuery(this).val());

  });
  jQuery(".choice_carpool").change(function(){
    carpoolOptions(jQuery(this).val());
  });

  function probabilityOptions(val)
  {
    if(val > 0)
    {
      jQuery(".probability_options").removeAttr('disabled');
      carpoolOptions(jQuery(".choice_carpool:checked").val());
    }
    else{
      jQuery(".probability_options").attr('disabled','disabled');
      carpoolOptions(0);
    }
  }
  function carpoolOptions(val)
  {
    if(val > 0)
    {
      jQuery(".carpool_options1").removeAttr('disabled');
    }
    else{
      jQuery(".carpool_options1").attr('disabled','disabled');
    }
    // places available only if offer carpool
    if(val == <?php echo EventSubscriptionTable::CARPOOL_ID_OFFER ?>)
    {
      jQuery(".carpool_options2").removeAttr('disabled');
    }
    else{
      jQuery(".carpool_options2").attr('disabled','disabled');
    }
  }
});
</script>


<form
  action="<?php echo url_for('@event_subscription_'.($form->getObject()->isNew() ? 'create' : 'update')) ?>"
  method="post"><?php if (!$form->getObject()->isNew()): ?> <input
  type="hidden" name="sf_method" value="put" /> <?php endif ?>


<table class="formtable" summary="Register a event subscription">
  <tfoot>
    <tr>
      <td colspan="2"><?php echo $form->renderHiddenFields() ?> <?php echo link_to('Annuler', $linkCancel, array('class'	=> 'blue button')) ?>

      <!-- Display delete button if object exists --> <input
        type="submit" value="Enregistrer" class="blue button" /></td>
    </tr>
  </tfoot>
  <tbody>
  <?php echo $form->renderGlobalErrors() ?>
    <tr>
      <th><?php echo $form['probability']->renderLabel() ?></th>
      <td><?php echo $form['probability'].' '.$form['probability']->renderError() ?></td>
    </tr>
    <tr class="rowHidden1">
      <th><?php echo $form['number_persons']->renderLabel() ?></th>
      <td><?php echo $form['number_persons'].' '.$form['number_persons']->renderError() ?></td>
    </tr>
    <tr class="subitem rowHidden1">
      <th colspan="2">Covoiturage</th>
    </tr>
    <tr class="rowHidden1">
      <th><?php echo $form['carpool_type']->renderLabel() ?></th>
      <td><?php echo $form['carpool_type'].' '.$form['carpool_type']->renderError() ?></td>
    </tr>
    <tr class="rowHidden2">
      <th><?php echo $form['carpool_smoker']->renderLabel() ?></th>
      <td><?php echo $form['carpool_smoker'].' '.$form['carpool_smoker']->renderError() ?></td>
    </tr>
    <tr class="rowHidden2">
      <th><?php echo $form['carpool_places']->renderLabel() ?></th>
      <td><?php echo $form['carpool_places'].' '.$form['carpool_places']->renderError() ?></td>
    </tr>

  </tbody>
</table>
</form>
