<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>

<form action="" method="post">
  <?php echo $form['due_state']->renderLabel() ?>
  <?php echo $form['due_state']->render() ?>

  <?php echo $form['by_page']->renderLabel() ?>
  <?php echo $form['by_page']->render() ?>

  <input type="submit" name="submit" value="Filtrer" class="blue small button" />
</form>