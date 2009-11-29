<?php

/**
 * Account
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    piwam
 * @subpackage model
 * @author     Adrien Mogenet
 * @version    SVN: $Id: Builder.php 6716 2009-11-12 19:26:28Z jwage $
 */
class Account extends BaseAccount
{
  protected $_totalExpenses = null;
  protected $_totalIncomes  = null;

  /**
   * Get object as string
   *
   * @return string
   */
  public function __toString()
  {
    return $this->getReference();
  }

  /**
   * Get total amount of expenses
   *
   * @return integer
   */
  public function getTotalExpenses()
  {
    if (null === $this->_totalExpenses)
    {
      $q = Doctrine_Query::create()
            ->select('SUM(e.amount) AS total')
            ->from('Expense e')
            ->where('e.account_id = ?', $this->getId())
            ->groupBy('e.account_id');

      $row = $q->fetchArray();

      if (count($row))
      {
        $this->_totalExpenses = $row[0]['total'];
      }
    }

    return ($this->_totalExpenses === null) ? 0 : $this->_totalExpenses;
  }

  /**
   * Get total amount of incomes
   *
   * @return integer
   */
  public function getTotalIncomes()
  {
    if (null === $this->_totalIncomes)
    {
      $q = Doctrine_Query::create()
            ->select('SUM(i.amount) AS total')
            ->from('Income i')
            ->where('i.account_id = ?', $this->getId())
            ->groupBy('i.account_id');

      $row = $q->fetchArray();

      if (count($row))
      {
        $this->_totalIncomes = $row[0]['total'];
      }
    }

    return ($this->_totalIncomes === null) ? 0 : $this->_totalIncomes;
  }

  /**
   * Get the total amount of this account
   *
   * @return integer
   */
  public function getTotal()
  {
    $total = $this->getTotalExpenses() - $this->getTotalIncomes();

    return ($total == null) ? 0 : $total;
  }

  /**
   * Determines if the Compte is negative of not
   *
   * @return boolean
   */
  public function isNegative()
  {
    return $this->getTotal() < 0;
  }

  /**
   * Set the reference of the Account but force the upper case
   *
   * @param string $value
   */
  public function setReference($value)
  {
    return $this->_set('reference', strtoupper($value));
  }
}