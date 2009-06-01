<h2>Gérer les droits</h2>



<form name="rightform" action="<?php echo url_for('membre/acl') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<table class="formArray">
    <tfoot>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Sauvegarder" class="button" />
            </td>
        </tr>
    </tfoot>

    <?php foreach ($form['rights'] as $key => $oneForm): ?>
        <tr>
            <td colspan="2"><h3><?php echo $form->getModuleName($key) ?></h3> <a href="#" onClick="check(<?php echo $key ?>)">tous</a></td>
        </tr>
        <?php foreach ($oneForm as $right): ?>
        <tr>
            <th>
                <?php echo $right->renderLabel() ?>
            </th>
            <td>
                <?php echo $right->render() ?>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>
</form>

<script type="text/javascript">
function check(number)
{
    var inputs = document.getElementsByTagName("input");
    for (var i = 0; inputs[i]; i++)
    {
        if (inputs[i].type == "checkbox") {
            var reg = new RegExp("^.*" + number + ".*$");
            if (inputs[i].name.match(reg)) {
                inputs[i].checked = true;
            }
        }
    }
}
</script>