<h2>Trombinoscope</h2>

<?php foreach ($membres as $membre): ?>
	<?php include_partial('picture', array('picture' => $membre->getPictureURI(), 'name' => $membre)) ?>
<?php endforeach ?>
