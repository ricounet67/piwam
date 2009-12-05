<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>


<form
    action="<?php echo url_for('@due_'.($form->getObject()->isNew() ? 'create' : 'update?id='.$form->getObject()->getId())) ?>"
    method="post"
    <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

    <?php if (!$form->getObject()->isNew()): ?>
        <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>



    <table class="formtable">
        <tfoot>
            <tr>
                <td colspan="2">
                    <?php echo $form->renderHiddenFields() ?>
                    <?php echo link_to('Liste',   '@dues_list', array('class' => 'formLinkButton')) ?>
                    <?php echo link_to('Annuler', '@dues_list', array('class'	=> 'formLinkButton')) ?>

                    <?php if (!$form->getObject()->isNew()): ?>
                        <?php echo link_to('Supprimer', '@due_delete?id=' . $form->getObject()->getId(), array('method'  => 'delete', 'confirm' => 'Ètes vous sûr ?', 'class'   => 'formLinkButton')) ?>
                    <?php endif ?>

                    <input type="submit" value="Sauvegarder" class="button" />
                </td>
            </tr>
        </tfoot>


        <tbody>
        <?php echo $form->renderGlobalErrors() ?>
            <tr>
                <th><?php echo $form['account_id']->renderLabel() ?> :</th>
                <td><?php echo $form['account_id'] ?> <?php echo $form['account_id']->renderError() ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form['due_type_id']->renderLabel() ?> :</th>
                <td><?php echo $form['due_type_id'] ?> <?php echo $form['due_type_id']->renderError() ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form['amount']->renderLabel() ?> :</th>
                <td><?php echo $form['amount'] ?> &euro; <?php echo $form['amount']->renderError() ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form['member_id']->renderLabel() ?> :</th>
                <td><?php echo $form['member_id'] ?> <?php echo $form['member_id']->renderError() ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form['date']->renderLabel() ?> :</th>
                <td><?php echo $form['date'] ?> <?php echo $form['date']->renderError() ?>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<!--
    Ajax updater can't update input form directly,
    so we update the following hidden <div>
-->
<div id="hiddenAmountValue"
    style="display: none"></div>

<!--
    The following AJAX behaviour update the hidden field
    with the requested amount, and then (onComplete)
    update the text input field
-->

<script type="text/javascript">
<!--
new Form.Element.EventObserver('due_due_type_id',
   function( element, value ) {
      new Ajax.Updater( 'hiddenAmountValue',  '<?php echo url_for("@duetype_ajax_getamount") ?>?id=' + value, { onComplete: function () { updateAmont(value) }, parameters: id=value });
   }
);

function updateAmont(v) {
      document.getElementById('due_amount').value = document.getElementById('hiddenAmountValue').innerHTML;
    }
//-->
</script>