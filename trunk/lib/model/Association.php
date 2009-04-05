<?php

class Association extends BaseAssociation
{
	/**
	 * Display the name of the association if we want to display the
	 * object.
	 * 
	 * @return 	string
	 * @since	r7
	 */
	public function __toString()
	{
		return $this->getNom();
	}
}
