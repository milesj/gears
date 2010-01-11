
<h1><?php echo $className; ?> v<?php echo $version; ?></h1>

<p><?php echo $description; ?><br />
<i><?php echo $extraInfo; ?></i></p>

<?php // Include another template and pass its private variables
echo $this->open('include', array('date' => date('Y'))); ?>