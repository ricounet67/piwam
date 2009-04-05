<?php

/**
 * Statut form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class StatutForm extends BaseStatutForm
{
	public function configure()
	{
		unset($this['created_at'], $this['updated_at']);
	}
}
