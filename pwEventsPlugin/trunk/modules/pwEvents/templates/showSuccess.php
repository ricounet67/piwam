<?php use_helper('Member','Date','JavascriptBase','jQuery','GMap','Asset') ?>

<?php include_stylesheets_for_form($formAddMember) ?>
<?php include_javascripts_for_form($formAddMember) ?>

<style type="text/css">
	table.subTable td {
		border: 0px none;
		padding: 0px 0px 0px 0px;
		vertical-align: top;
	}
	.textCarpoolOffer {
		color: green;
	}
	.textCarpoolNeed {
		color: blue;
	}
</style>
<script>
  var carpoolMapCurrentWindow = null;
	function carpoolMapOpenWindow(member_id)
	{
		if(carpoolMapCurrentWindow != null)
		{
			carpoolMapCurrentWindow.close();
		}
		var window = null;
		var marker = null;
		// test if the marker of user exist on map and get window info and marker
		eval("if(typeof map_window_member_"+member_id+" != 'undefined'){ window = map_window_member_"+member_id+"; marker = map_marker_member_"+member_id+";}");
		if( window != null)
		{
			window.open(<?php echo $carpool_map->getJsName() ?>,marker);
			carpoolMapCurrentWindow = window;
		}
		else{
			alert("Erreur cette personne ne possède pas une adresse correct pour être sur la carte !");
		}
	}
	
</script>
<h2><?php echo $event->getName() ?></h2>

<table >
<tr>
<?php if($canValidateAndEdit): ?>
	<td><?php echo link_to('Accepter','@event_validate?id='.$event->getId(),array('class' => 'button blue')) ?></td>
	<td><?php echo link_to('Modifier','@event_edit?id='.$event->getId(),array('class' => 'button blue')) ?></td>
<?php endif ?>
	<td><?php echo link_to('Liste événements','@events_list',array('class' => 'button blue')) ?></td>
	<td><?php echo link_to('Calendrier','@events_calendar',array('class' => 'button blue')) ?></td>
<?php if($canRegister): ?>
	<td><?php echo link_to("S'inscrire",'@event_subscription_register?event_id='.$event->getId(),array('class' => 'button blue')) ?></td>
<?php endif ?>
</tr>
</table>
<br/>

<table class="details" >
<tr>
	<th>Prévu le </th><td><?php echo format_date($event->getDateBegin().' '.$event->getTimeBegin(),'dd/MM/yyyy à HH:mm') ?>h</td>
</tr>

<tr>
	<th colspan="2">Description</th>
</tr>
<tr>
	<td colspan="2"><?php echo html_entity_decode($event->getDescriptionPublic()) ?></td>
</tr>
<?php if($canSeePrivate): ?>
<tr>
	<th>Détails privée</th><td><?php echo $event->getDescriptionPrivate() ?></td>
</tr>
<?php endif ?>
<tr>
	<th>Adresse</th><td><?php echo $event->getAddress() ?></td>
</tr>

<tr>
	<th>Organisé par</th><td><?php echo format_member($event->getOrganizedByMember()) ?></td>
</tr>
<tr>
	<th>Création</th><td>Le <?php echo format_date($event->getCreatedAt()).' par '.format_member($event->getCreatedByMember()) ?></td>
</tr>
<tr>
	<th>Validation</th>
	<td>
	<?php if($event->isAccepted()): ?>
		Accepté par <?php echo format_member($event->getAcceptedByMember()) ?>
	<?php else: ?>
		Pas encore accepté
	<?php endif ?>
	</td>
</tr>

<!-- Register and carpool only after event accepted -->
<?php if($event->isAccepted()): ?>
	<tr>
		<th>Participants inscrit</th>
		<td><?php foreach($membersRegister as $member){
					echo format_member($member).', ';
		}?>
		<?php if(count($membersRegister) == 0 ): ?>
			Personne pour l'instant, soyez le premier !
		<?php endif ?>
		</td>
	</tr>
	
	<!-- Add member for manager -->
	<?php if($canManage && $canRegister):?>
	<tr><th>Ajouter participant</th>
		<td><form action="<?php echo url_for('@event_subscription_register?event_id='.$event->getId()) ?>" method="post">
			<?php echo $formAddMember['member_id'] ?>
			<input type="submit" value="Ajouter" class="add blue button" />
		</form>
	</td></tr>
	<?php endif ?>

	<!-- carpool members list -->
	<tr><th colspan="2" style="text-align:center">Covoiturage</th></tr>
	<tr><td colspan="2" style="padding: 0px;">
	<?php if(count($carpool_registers_need) + count($carpool_registers_offer) > 0): ?>
	<table width="100%" class="subTable">
	<tr >
		<td width="50%" style="padding: 0px;">
		<?php if(count($carpool_registers_offer) > 0): ?>
			<table width="100%" class="subTable"><thead><tr><th>Places disponibles</th></tr></thead>
				<tbody>
					<?php foreach($carpool_registers_offer as $offer): ?>
						<tr><td><?php echo jq_link_to_function($offer->getMember()->getName(),'carpoolMapOpenWindow('.$offer->getMember()->getId().')') ?> : 
							<?php echo $offer->getCarpoolPlaces() ?> places</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		<?php endif ?>
		</td>
	
		<td width="50%" style="padding: 0px;">
		<?php if(count($carpool_registers_need) > 0): ?>
			<table width="100%" class="subTable"><thead><tr><th>Cherche des places</th></tr></thead>
				<tbody>
					<?php foreach($carpool_registers_need as $need): ?>
						<tr><td><?php echo jq_link_to_function($need->getMember()->getName(),'carpoolMapOpenWindow('.$need->getMember()->getId().')') ?> : 
							<?php echo $need->getNumberPersons() ?> places</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		<?php endif ?>
		</td>
	</tr>
	</table>
	<?php else: ?>	
			<br/>Personne ne cherche ou ne propose de places de covoiturage.<br/>
	<?php endif ?>
	</td></tr>
	
	<!-- carpool map -->
	<?php if($carpool_map != null ): ?>
	<tr><th colspan="2" style="text-align:center">Carte de l'événement</th></tr>
	<tr><td colspan="2">
		<?php include_map($carpool_map,array('height'=>'400px'))?>
		<table style="border: 1px solid #999; margin-top: 15px; margin-bottom: 10px; width: 100%;" class="subTable">
		  <tr style="font-weight: bold; background-color: #ddd; color: #555;">
		    <td colspan="4">Légende&nbsp;</td>
		  </tr>
		  <tr>
		  	<td width="20px"><?php echo image_tag(pwEventsPluginUtil::IMAGES_PATH.'home.png',array('size'=>'24x24')) ?></td><td>Chez moi</td>
		  	<td><?php echo image_tag(pwEventsPluginUtil::IMAGES_PATH.'end_flag.png',array('size'=>'24x24')) ?></td><td>Adresse de l'événement</td>
		  </tr><tr>
		  	<td><?php echo image_tag(pwEventsPluginUtil::IMAGES_PATH.'flag_blue.png',array('size'=>'24x24')) ?></td><td>Cherche des places</td>
		  	<td><?php echo image_tag(pwEventsPluginUtil::IMAGES_PATH.'flag_green.png',array('size'=>'24x24')) ?></td><td>Propose des places</td>
		  </tr>
	  </table>
	  </td>
	</tr>
	<!-- End carpool map if -->
	<?php endif ?>
<!-- End if event is accepted -->
<?php endif ?>
</table>	
	
<!-- must be included at the bottom of page -->
<?php if($event->isAccepted() && $carpool_map != null ) { include_map_javascript($carpool_map); } ?>
