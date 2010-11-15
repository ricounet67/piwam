
<style type="text/css">
.dayHeaderCurrentMonth {
	background-color: #e0e0e0;
}

.dayCellToday {
	background-color: #6ac152;
}
</style>
<table width="100%">
  <tr>
    <td width="33%"><b><?php echo link_to($prevTitle,'@events_calendar?year='.$prevYear.'&month='.$prevMonth) ?></b></td>
    <td width="34%" style="text-align: center">
    <h2><?php echo $currentTitle ?></h2>
    </td>
    <td width="33%" style="text-align: right"><b><?php echo link_to($nextTitle,'@events_calendar?year='.$nextYear.'&month='.$nextMonth) ?></b></td>
  </tr>
</table>



<table class="datalist">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>Lundi</th>
      <th>Mardi</th>
      <th>Mercredi</th>
      <th>Jeudi</th>
      <th>Vendredi</th>
      <th>Samedi</th>
      <th>Dimanche</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($calendar as $week => $days ): ?>
    <tr>
      <td><?php echo $firstWeekMonth+$week ?></td>
      <?php foreach($days as $day => $events): ?>
      <td width="14%" height="100px"
        style="border: solid 1px black; padding: 0px; vertical-align: top;"
        <?php if(date('Y-m-d') == $day): ?> class="dayCellToday"
        <?php endif ?>>
      <table width="100%" height="100%" style="padding: 0px">
        <tr height="20px"
        <?php if(intval(date('m',strtotime($day)) == $currentMonth)): ?>
          class="dayHeaderCurrentMonth" <?php endif ?>>
          <th><?php echo date('d',strtotime($day)) ?></th>
        </tr>
        <tr>
          <td>
          <ul>
          <?php foreach($events as $key => $value): ?>
            <li>&bull; <?php echo link_to($value['event']->getName(),'@event_show?id='.$value['event']->getId())//.' à '. $value['event']->getTimeBegin()?>
            </li>
            <?php endforeach ?>
          </ul>
          </td>
        </tr>
      </table>
      </td>
      <?php endforeach ?>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>
<br/>
<?php if($hasRightAddEvent){
  echo link_to('Créer un événement','@event_new',array('class'=>'add blue button'));
}?>
