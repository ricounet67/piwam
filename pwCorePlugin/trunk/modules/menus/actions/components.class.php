<?php
/**
 * Menu entries management class
 *
 * @since   1.2
 * @author  Julien Pottier <potti008@gmail.com>
 */
class menusComponents extends sfComponents
{
  /**
   * generating the left menu in this component
   * from parsing the menus section in app.yml (overloadable)
   */
  public function executeGenerateMenu()
  {
    $menu = sfConfig::get('app_menus');
    $menu_order = array();
    $this->menus = array();

    foreach ($menu as $section_name => $section)
    {
      foreach($section['items'] as $item_name => $item)
      {
      	if (null === $item)
        {
          unset($menu[$section_name]['items'][$item_name]);
        }
        else
        {
          if (isset($item['credentials']) && (null !== $item['credentials']) && !$this->getUser()->hasCredential($item['credentials']))
          {
            unset($menu[$section_name]['items'][$item_name]);
          }
        }
      }
      if (empty($menu[$section_name]['items']))
      {
        unset($menu[$section_name]);
      }
      else
      {
        if (isset($section['order']) && (null !== $section['order']) && is_int($section['order']))
        {
          $menu_order[$section['order']] = $menu[$section_name];
          unset($menu[$section_name]);
        }
      }
    }
    

    /*
  	 * we count the number of element to order
    */
    $nb = count($menu) + count($menu_order);

    for ($i = 0; $i < $nb; $i++)
    {
      /*
  		 * Check if there is a menu order to this index
       */
      if (! empty($menu_order[$i]))
      {
        $this->menus[] = $menu_order[$i];
        unset($menu_order[$i]);
      }
      else
      {
        if (count($menu))
        {
          $this->menus[] = array_shift($menu);
        }
        else
        {
          break;
        }
      }
    }
    foreach ($menu_order as $else)
    {
      $this->menus[] = $else;
    }
  }
}