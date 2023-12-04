<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php foreach ($this->items as $item) :
    $payment =((int)$this->data['price'] - (int)$this->data['prepayment'])*(1 + $item->remuneration*.01);
?>
<tr>
    <td><?=$item->term?></td>
    <td><?=number_format($this->data['price'], 2,"."," ")?></td>
    <td><?=$item->term?></td>
    <td><?= ( number_format($payment/$item->term, 2,"."," ") ) ?></td>
    <td><?= ( number_format($payment, 2,"."," ")) ?></td>
</tr>
<?php endforeach;?>