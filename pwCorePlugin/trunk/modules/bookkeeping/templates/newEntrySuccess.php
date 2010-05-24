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

<?php echo include_partial('entryForm', array('form' => $form)) ?>

<script type="text/javascript">
  var numberOfCredits = <?php echo count($form['credits']) ?>;
  var numberOfDebits = <?php echo count($form['debits']) ?>;

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
   * Add a new Debit form. The new debit will be numbered `num`
   *
   * @param   integer   num
   * @return  string    HTML content for displaying new Debit Form
   */
  function addDebit(num)
  {
    var response = jQuery.ajax({
      type:   'GET',
      url:    '<?php echo url_for('bookkeeping/addDebitForm')?>' + '<?php echo ($form->getObject()->isNew()? '' : '?id=' . $form->getObject()->getId()) . ($form->getObject()->isNew() ? '?num=' : '&num=') ?>' + num,
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
    document.getElementById('credits_container').removeChild(document.getElementById('credit_' + num));
    numberOfCredits = numberOfCredits - 1;
  };

  /**
   * Delete a Credit form
   *
   * @param   integer   num : The number of creditForm to delete
   */
  function deleteDebit(num)
  {
    document.getElementById('debits_container').removeChild(document.getElementById('debit_' + num));
    numberOfDebits = numberOfDebits - 1;
  };

  /*
   * Add behaviour on the 'Add' buttons
   */
  jQuery().ready(function()
  {
    jQuery('#add_credit').click(function() {
      jQuery("#credits_container").append(addCredit(numberOfCredits));
      numberOfCredits = numberOfCredits + 1;
    });

    jQuery('#add_debit').click(function() {
      jQuery("#debits_container").append(addDebit(numberOfDebits));
      numberOfDebits = numberOfDebits + 1;
    });
  });
</script>