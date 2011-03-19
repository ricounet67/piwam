<?php use_helper('Member','Date') ?>

<?php if($sf_user->hasFlash('notice')): ?>
  <p class="notice"><?php echo $sf_user->getFlash('notice') ?></p>
<?php endif ?>

<h2>Liste des événements</h2>

<table class="datalist">

<thead>
<tr>
	<th width="50%">Titre</th>
	<th width="10%">Prévu le</th>
	<th>Organisé par</th>
	<th>Etat</th>
	<th>Actions</th>
</tr>
</thead>

<tbody>
<?php foreach($events as $event): ?>
<tr>
	<td><?php echo link_to($event->getName(),'@event_show?id='.$event->getId()) ?></td>
	<td><?php echo format_date($event->getDateBegin()) ?></td>
	<td><?php echo format_member($event->getOrganizedByMember())?></td>
	<td><?php echo $event->getStatusString() ?></td>
	<td><?php echo link_to('[Voir]','@event_show?id='.$event->getId()) ?>
			<?php if($event->isNotValidated()): ?>
				<?php echo link_to('[Modifier]','@event_edit?id='.$event->getId()) ?>
			<?php endif ?>
	</td>
</tr>
<?php endforeach ?>
<?php if(count($events) == 0): ?>
	<tr><td colspan="4">Aucun événement prévu</td></tr>
<?php endif ?>
</tbody>

</table>
<?php echo link_to('Nouvel événement','@event_new',array('class'=>'button grey add'))?>