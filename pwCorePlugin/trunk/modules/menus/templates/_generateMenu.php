<?php foreach($menus as $element):?>
  <ul>
  <li class="mainSection"><?php echo $element['label'];?></li>
  <?php foreach($element['items'] as $item):?>
    <li><?php echo link_to($item['name'], $item['uri'] ); ?></li>
  <?php endforeach;?>
  </ul>
<?php endforeach;?>

