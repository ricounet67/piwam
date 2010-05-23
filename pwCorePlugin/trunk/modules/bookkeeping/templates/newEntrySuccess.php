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
  var numberOfCredits = <?php echo $counter ?>;

  /**
   * Add a new Credit form. The new credit will be numbered `num`
   *
   * @param   integer   num
   * @return  string    HTML content for displaying new Credit Form
   */
  function addCredit(num)
  {
    var response = jQuery.ajax({
      type:   'GET',
      url:    '<?php echo url_for('bookkeeping/addCreditForm')?>' + '<?php echo ($form->getObject()->isNew()? '' : '?id=' . $form->getObject()->getId()) . ($form->getObject()->isNew() ? '?num=' : '&num=') ?>' + num,
      async:  false
    }).responseText;

    return response;
  };

  /**
   * Delete a Credit form
   *
   * @param   integer   num : The number of creditForm to delete
   */
  function deleteCredit(num)
  {
    document.getElementById('credit_container').removeChild(document.getElementById('credit_' + num));
    numberOfCredits = numberOfCredits - 1;
  };

  /*
   * Add behaviour on the 'Add' buttons
   */
  jQuery().ready(function()
  {
    jQuery('button#add_credit').click(function() {
      jQuery("#credit_container").append(addCredit(numberOfCredits));
      numberOfCredits = numberOfCredits + 1;
    });
  });
</script>