<?php
use_helper('boolean');
?>

<h2>Configurer</h2>

<h3>Listes des champs supplémentaires :</h3>

<table class="datalist">
  <thead>
    <tr>
      <th>Nom du champ</th>
      <th>Type</th>
      <th>Valeur par défaut</th>
      <th>Description</th>
      <th width="80px">Obligatoire</th>
    </tr>
  </thead>
  <tbody>

    <?php foreach($extraRows as $row): ?>
      <tr>
        <td><?php echo $row->getLabel() ?></td>
        <td><?php echo $row->getType() ?></td>
        <td><?php echo $row->getDefaultValue() ?></td>
        <td><?php echo $row->getDescription() ?></td>
        <td><?php echo boolean2icon($row->getRequired()) ?></td>
      </tr>
    <?php endforeach ?>
      
  </tbody>
</table>

<script type="text/javascript">

  /*
   * Customize the behaviour of the 'parameters' field
   * according to the value of the 'type' field.
   */
  function ShowParameters(type)
  {
    if (type == "string")
    {
      document.getElementById("parameters").style.display = "table-row";
      document.getElementById("parameters_label").innerHTML = "Taille maximale";
      document.getElementById("parameters_help").innerHTML = "Le nombre maximal \n\
        de caractères.<br />Laissez vide pour ne pas spécifier de valeur";
    }

    if (type == "number")
    {
      document.getElementById("parameters").style.display = "table-row";
      document.getElementById("parameters_label").innerHTML = "Intervalle";
      document.getElementById("parameters_help").innerHTML = "0 - 134 : La valeur\n\
        devra être comprise entre 0 et 134.<br />Laissez vide pour accepter \n\
        toutes les valeurs.";
    }

    if (type == "choices")
    {
      document.getElementById("parameters").style.display = "table-row";
      document.getElementById("parameters_label").innerHTML = "Choix possibles";
      document.getElementById("parameters_help").innerHTML = "choix1,choix2,choix3 :\n\
        Choix entre ces 3 valeurs.";
    }

    // Don't display extra field
    if (type == "" || type == "boolean" || type == "text" || type == "date")
    {
      document.getElementById("parameters").style.display= "none";
      document.getElementById("parameters_label").innerHTML = "Paramètres";
      document.getElementById("parameters_help").innerHTML = "";
    }
  }
</script>

<h3>Ajouter un champ :</h3>
<form action="<?php echo url_for('@config_members') ?>" method="post">
<?php echo $form->renderHiddenFields() ?>
<table class="formtable">
  <tr>
    <th><?php echo $form['label']->renderLabel() ?></th>
    <td><?php echo $form['label'] . $form['label']->renderError() ?></td>
  </tr>
  <tr>
    <th><?php echo $form['type']->renderLabel() ?></th>
    <td><?php echo $form['type'] . $form['type']->renderError() ?></td>
  </tr>

  <!-- Extra parameters row -->
  <tr style="display: none" id="parameters">
    <th><span id="parameters_label">Paramètres</span></th>
    <td>
      <?php echo $form['parameters'] ?><br />
      <span id="parameters_help"></span>
    </td>
  </tr>
  
  <tr>
    <th><?php echo $form['default_value']->renderLabel() ?></th>
    <td><?php echo $form['default_value'] . $form['default_value']->renderError() ?></td>
  </tr>
  <tr>
    <th><?php echo $form['description']->renderLabel() ?></th>
    <td><?php echo $form['description'] . $form['description']->renderError() ?></td>
  </tr>
  <tr>
    <th><?php echo $form['required']->renderLabel() ?></th>
    <td><?php echo $form['required'] ?></td>
  </tr>
  <tr><td colspan="2"><input type="submit" class="button grey" /></td></tr>
</table>
</form>

<!-- When reloading the page, ensure that we
     still display the great 'parameter' field -->

<script type="text/javascript">
  ShowParameters(document.getElementById("member_extra_row_type").value);
</script>