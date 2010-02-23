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
      $isRequired = $row->getRequired();

      switch ($row->getType())
      {
        case 'string':
          $this->widgetSchema[$row->getSlug()] = new sfWidgetFormInput();
          $this->widgetSchema[$row->getSlug()]->setAttribute('class', 'formInputNormal');
          $this->validatorSchema[$row->getSlug()] = new sfValidatorString(array('required' => $isRequired));
          break;

        case 'date':
          $this->widgetSchema[$row->getSlug()] = new sfWidgetFormJQueryDate(array(
            'image'   => image_path('calendar.gif'),
            'config'  => '{}',
            'culture' => 'fr_FR',
            'format'  => '%day%.%month%.%year%',
            'years'   => range(date('Y'), '1900'),
          ));
          $this->validatorSchema[$row->getSlug()] = new sfValidatorDate(array('required' => $isRequired));
          break;

        case 'text':
          $this->widgetSchema[$row->getSlug()] = new sfWidgetFormTextarea();
          $this->validatorSchema[$row->getSlug()] = new sfValidatorString(array('required' => $isRequired));
          break;

        case 'choices':
          $choices = $row->getParametersAsChoices();
          $this->widgetSchema[$row->getSlug()] = new sfWidgetFormChoice(array('choices' => $choices));
          $this->widgetSchema[$row->getSlug()]->setAttribute('class', 'formInputNormal');
          $this->validatorSchema[$row->getSlug()] = new sfValidatorChoice(array('choices' => $choices));
          break;
      }

      $this->widgetSchema[$row->getSlug()]->setLabel($row->getLabel());
    }
  }
}
?>
