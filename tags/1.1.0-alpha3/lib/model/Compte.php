<?php

class Compte extends BaseCompte
{
	// Allow to store total amounts in order to avoid re-computing if it
	// has been already done
	protected	$_totalDepenses = null;
	protected	$_totalRecettes = null;


	/**
	 * We display the reference of the account if we would like to
	 * display it
	 *
	 * @return  string
	 * @since   r5
	 */
	public function __toString()
	{
		return $this->getReference();
	}


	/**
	 * Retrieve the total amount of Depenses within the Compte
	 *
	 * @return	integer
	 * @since	r9
	 */
	public function getTotalDepenses()
	{
		if (is_null($this->_totalDepenses))
		{
			$c = new Criteria();
			$c->clearSelectColumns();
			$c->addAsColumn('TOTAL_DEPENSES', 'SUM(' . DepensePeer::MONTANT . ')');
			$c->add(DepensePeer::COMPTE_ID, $this->getId());
			$result = DepensePeer::doSelectStmt($c);
			$row = $result->fetch();
			$this->_totalDepenses = $row['TOTAL_DEPENSES'];
		}
		
		return $this->_totalDepenses;
	}
	
	
	/**
	 * Retrieve the total amount of Recettes within the Compte
	 *
	 * @return	integer
	 * @since	r9
	 */
	public function getTotalRecettes()
	{
		if (is_null($this->_totalRecettes))
		{
			$c = new Criteria();
			$c->clearSelectColumns();
			$c->addAsColumn('TOTAL_RECETTES', 'SUM(' . RecettePeer::MONTANT . ')');
			$c->add(RecettePeer::COMPTE_ID, $this->getId());
			$result = RecettePeer::doSelectStmt($c);
			$row = $result->fetch();
			$this->_totalRecettes = $row['TOTAL_RECETTES'];
		}
		
		return $this->_totalRecettes;
	}
	
	
	/**
	 * Retrieve the actual total (recettes - depenses) of the current account
	 * 
	 * @return 	integer
	 * @since	r9
	 */
	public function getTotal()
	{
		return $this->getTotalRecettes() - $this->getTotalDepenses();
	}
	
	
	/**
	 * Determines if the Compte is negative of not
	 * 
	 * @return	boolean
	 */
	public function isNegative()
	{
		return $this->getTotal() < 0;
	}
	
	/**
	 * Set the reference of the Compte but force the upper case
	 * 
	 * @param 	string	$value
	 * @since	r25
	 */
	public function setReference($value)
	{
		parent::setReference(strtoupper($value));
	}
}
