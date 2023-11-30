<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php foreach ($this->items as $item) : ?>
<p><?=$item->term?></p>
<p><?=$item->remuneration?></p>
<?php endforeach;?>