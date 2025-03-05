<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
echo new JResponseJson( ['items' => $this->items] );