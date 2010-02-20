<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Form with all the MemberExtraRows defined by the user
 *
 * @package     piwam
 * @subpackage  lib
 * @author      adrien
 * @since       1.2
 */
class MemberExtraRowsForm extends sfForm
{
  /**
   * Dynamically configure the existing extra rows
   */
  public function configure()
  {
    $id = 1;
    $rows = MemberExtraRowTable::getForAssociation($id);

    foreach ($rows as $row)
    {
      switch ($row->getType())
      {
        case 'string':
          $this->widgetSchema[$row->getLabel()] = new sfWidgetFormInput();
          $this->widgetSchema[$row->getLabel()]->setLabel($row->getLabel());
          $this->widgetSchema[$row->getLabel()]->setAttribute('class', 'formInputNormal');
          $this->validatorSchema[$row->getLabel()] = new sfValidatorString();
          break;

        case 'date':
          $this->widgetSchema[$row->getLabel()] = new sfWidgetFormJQueryDate(array(
            'image'   => image_path('calendar.gif'),
            'config'  => '{}',
            'culture' => 'fr_FR',
            'format'  => '%day%.%month%.%year%',
            'years'   => range(date('Y'), '1950'),
          ));
          $this->widgetSchema[$row->getLabel()]->setLabel($row->getLabel());
          $this->validatorSchema[$row->getLabel()] = new sfValidatorDate();
          break;

        case 'text':
          $this->widgetSchema[$row->getLabel()] = new sfWidgetFormTextarea();
          $this->validatorSchema[$row->getLabel()] = new sfValidatorString();
          break;

        case 'choices':
          $choices = $row->getParametersAsChoices();
          $this->widgetSchema[$row->getLabel()] = new sfWidgetFormChoice(array('choices' => $choices));
          $this->widgetSchema[$row->getLabel()]->setAttribute('class', 'formInputNormal');
          $this->validatorSchema[$row->getLabel()] = new sfValidatorChoice(array('choices' => $choices));
          break;
      }
    }
  }
}
?>
