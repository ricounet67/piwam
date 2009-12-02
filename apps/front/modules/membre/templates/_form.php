<?php include_stylesheets_for_form($form) ?>
<?php
include_javascripts_for_form($form);
use_helper('JavascriptBase');
use_javascript('custom-forms/si.files.js')

/**
 * Possible input values:
 * ======================
 *
 *  - $first    : set if we are registering the first user which is himself
 *                registering a new association
 *
 *  - $pending  : set if the form is filled by a user which is requesing
 *                a subscription to an existing association
 */
?>


<!-- To customize "browse" button -->
<script type="text/javascript" language="javascript">
    // <![CDATA[
    SI.Files.stylizeAll();
</script>

<form action="<?php
    	if (isset($first))
    	{
    		echo url_for('@member_first');
    	}
    	elseif (isset($pending))
    	{
            echo url_for('@member_ask_subscription');
    	}
    	else
    	{
    		echo url_for('@member_' . ($form->getObject()->isNew() ? 'create' : 'update?id=' . $form->getObject()->getId()));
    	}
    	?>"

    method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

    <?php if (!$form->getObject()->isNew()): ?>
        <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>

<table class="formtable">

    <!-- Form footer which display buttons -->

    <tfoot>
        <tr>
            <td colspan="2">
                <?php echo $form->renderHiddenFields() ?>

                <!-- Cancel button only if this is not the first member -->

                <?php if (! isset($first)): ?>
                        <?php echo link_to('Annuler', 'membre/index', array('class'	=> 'formLinkButton')) ?>
                <?php endif; ?>



                <!-- Delete button only if object already exists -->

                <?php if (! $form->getObject()->isNew()): ?>
	                	<?php echo link_to('Supprimer', '@member_delete?id=' . $form->getObject()->getId(),
	                	                                 array(
                                                    		'class'   => 'formLinkButton',
                                                    		'method'  => 'delete',
                                                    		'confirm' => 'Etes vous sûr ?'
                                                		)) ?>
        		<?php endif; ?>



                <!-- Submit button value according to the state -->

        		<?php if ((isset($first)) && ($first)): ?>
                    <input type="submit" value="Étape suivante >" class="button" />
                <?php else: ?>
                    <input type="submit" value="Sauvegarder" class="button" />
                <?php endif; ?>

            </td>
        </tr>
    </tfoot>


    <tbody>
    <?php echo $form->renderGlobalErrors() ?>
        <tr>
            <th><?php echo $form['lastname']->renderLabel() ?>*</th>
            <td><?php echo $form['lastname'] ?><?php echo $form['lastname']->renderError() ?></td>
        </tr>
        <tr>
            <th><?php echo $form['firstname']->renderLabel() ?>*</th>
            <td><?php echo $form['firstname'] ?><?php echo $form['firstname']->renderError() ?></td>
        </tr>
        <tr>
            <th>Pseudo <?php echo ($form->isFirstRegistration()) ? '*' : ''; ?></th>
            <td><?php echo $form['username'] ?><?php echo $form['username']->renderError() ?></td>
        </tr>
        <tr>
            <th>Mot de passe <?php echo ($form->isFirstRegistration()) ? '*' : ''; ?></th>
            <td><?php echo $form['password'] ?><?php echo $form['password']->renderError() ?></td>
        </tr>
        <tr>
            <th>Statut</th>
            <td><?php echo $form['status_id'] ?><?php echo $form['status_id']->renderError() ?></td>
        </tr>
        <tr>
            <th>Photo</th>
            <td><label class="custom"><?php echo $form['picture'] ?><?php echo $form['picture']->renderError() ?></label></td>
        </tr>
        <tr>
            <th>Date d'inscription</th>
            <td><?php echo $form['subscription_date'] ?><?php echo $form['subscription_date']->renderError() ?></td>
        </tr>
        <tr>
            <th>Exempté de cotisation</th>
            <td><?php echo $form['due_exempt'] ?><?php echo $form['due_exempt']->renderError() ?></td>
        </tr>
        <tr>
            <th><?php echo $form['street']->renderLabel() ?></th>
            <td><?php echo $form['street'] ?><?php echo $form['street']->renderError() ?></td>
        </tr>
        <tr>
            <th>Code postal</th>
            <td><?php echo $form['zipcode'] ?><?php echo $form['zipcode']->renderError() ?></td>
        </tr>
        <tr>
            <th><?php echo $form['city']->renderLabel() ?></th>
            <td><?php echo $form['city'] ?><?php echo $form['city']->renderError() ?></td>
        </tr>
        <tr>
            <th><?php echo $form['country']->renderLabel() ?></th>
            <td><?php echo $form['country'] ?><?php echo $form['country']->renderError() ?></td>
        </tr>
        <tr>
            <th><?php echo $form['email']->renderLabel() ?></th>
            <td><?php echo $form['email'] ?><?php echo $form['email']->renderError() ?></td>
        </tr>
        <tr>
            <th>Site internet/blog</th>
            <td><?php echo $form['website'] ?><?php echo $form['website']->renderError() ?></td>
        </tr>
        <tr>
            <th>Téléphone fixe</th>
            <td><?php echo $form['phone_home'] ?><?php echo $form['phone_home']->renderError() ?></td>
        </tr>
        <tr>
            <th>Téléphone portable</th>
            <td><?php echo $form['phone_mobile'] ?><?php echo $form['phone_mobile']->renderError() ?></td>
        </tr>
    </tbody>
</table>
</form>
