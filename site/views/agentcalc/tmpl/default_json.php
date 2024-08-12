<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
if((int)$this->data['price']):
?>
    <?php foreach ($this->items as $item) :
        $payment =((float)$this->data['price'] - (float)$this->data['prepayment'])*(1 + $item->remuneration*.01);
    ?>
        <tr>
            <td><?=$item->term?></td>
            <td><?=number_format($this->data['price'], 2,"."," ")?></td>
            <td><?=$item->term?></td>
            <td><?= ( number_format($payment/$item->term, 2,"."," ") ) ?></td>
            <td><?= ( number_format($payment, 2,"."," ")) ?></td>
        </tr>
    <?php endforeach;?>
<?php else : ?>
    <?php foreach ($this->items as $item) {
        $payment = $this->data['payment'];
        echo "<tr>
            <td>{$item->term}</td>
            <td>" . number_format(  (float)$this->data['prepayment'] + $item->term * $payment / (1 + $item->remuneration*.01), 2,"."," " ) ."</td>
            <td>$item->term</td>
            <td>" . number_format( (float)$payment, 2,"."," "  ) . "</td>
            <td>" .  number_format( (float)$this->data['prepayment'] + $item->term * $payment, 2,"."," "  ) . "</td>
        </tr>";
     } ?>
<?php endif; ?>
