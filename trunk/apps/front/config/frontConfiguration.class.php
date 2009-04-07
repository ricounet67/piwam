<?php

class frontConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
      //define('GMAP_KEY',     'ABQIAAAAL8IvKFhg9nRCwpMHeoYEKhSjC3XvBgUeww0y5aZcY4GDmTZpmBQylDJNZrY3dHm2Q1kLZn5ehZeNuw');
      define('GMAP_KEY',	 	'ABQIAAAAL8IvKFhg9nRCwpMHeoYEKhS1lNceYgF8xlyvwVnMFdwAaj__chQw8Ns5gv_V85Qsjn8lSFzeLY8r4Q');
      
      // Represents the states of `actif` fields
      define('ENABLED',			1);
      define('DISABLED',		0);
  }
}
