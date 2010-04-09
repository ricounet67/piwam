<?php
 
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
  	
  	
  	foreach ($menu as $section_name => $section){
  		foreach($section['items'] as $item_name => $item){
  			if( isset($item['credentials']) && !is_null($item['credentials']) && !$this->getUser()->hasCredential($item['credentials']) ){
  				unset($menu[$section_name]['items'][$item_name]);
  			}
  		}
  	  if( empty($menu[$section_name]['items']) ){
         unset($menu[$section_name]);
      }
      else
      {
      	if( isset($section['order']) && !is_null($section['order']) && is_int($section['order']) )
      	{
      		$menu_order[$section['order']] = $section;
      		unset($menu[$section_name]);
      	}
      }
  	}
  	
  	/*
  	 * we count the number of element to order
  	 */
  	$nb = count($menu) + count($menu_order);
  	
  	for($i = 0 ; $i < $nb ; $i++ )
  	{
  		/*
  		 * check if there is a menu order to this index
  		 */
  		if(!empty($menu_order[$i]))
  		{
  			echo 'rentre-'.$i.'/';
  			$this->menus[] = $menu_order[$i];
  			unset($menu_order[$i]);
  		}
  		else
  		{
  			if(count($menu))
  			{
  			   $this->menus[] = array_shift($menu) ;
  			}
  			else
  			{
  				break;
  			}
  		}
  	}
  	foreach($menu_order as $else)
  	{
  		$this->menus[] = $else ;
  	}
  	
  }
}