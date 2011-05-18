
<h1><?php echo $className; ?> v<?php echo $version; ?></h1>

<p><?php echo $description; ?><br />
<i><?php echo $extraInfo; ?></i></p>

<ul>
	<?php foreach ($methods as $method) { ?>
	<li><?php echo $method; ?>()</li>
	<?php } ?>
</ul>

<?php // Include another template and pass its private variables
echo $this->open('includes/footer', array('date' => date('Y')), true); ?>