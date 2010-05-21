<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>

<?php use_helper('jQuery') ?>

<h2>Nouvelle écriture</h2>

<table>
  <tbody id="credit_container">

  </tbody>
</table>

<table class="formtable">
  <?php echo $form ?>
  <tr>
    <td colspan="2"><button id="add_credit" type="button"><?php echo "Add Credit" ?></button></td>
  </tr>
</table>


<?php $counter = 0; ?>

<script type="text/javascript">

var cnt = <?php echo $counter ?>;

/*
 * Add a new Credit form
 */
function addCredit(num)
{
  var r = jQuery.ajax({
    type:   'GET',
    url:    '<?php echo url_for('bookkeeping/addCreditForm')?>' + '<?php echo ($form->getObject()->isNew()? '' : '?id=' . $form->getObject()->getId()) . ($form->getObject()->isNew() ? '?num=' : '&num=') ?>' + num,
    async:  false
  }).responseText;
  
  return r;
};

/*
 * Delete a Credit form
 */
function delCredit(num)
{
  document.getElementById('credit_container').removeChild(document.getElementById('credit_' + num));
  cnt = cnt - 1;
};

/*
 * Add behaviour on 'add' button
 */
jQuery().ready(function()
{
  jQuery('button#add_credit').click(function() {
    jQuery("#credit_container").append(addCredit(cnt));
    cnt = cnt + 1;
  });
});
</script>