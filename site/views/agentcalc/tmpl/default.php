<?php
defined('_JEXEC') or exit();
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');
?>
<div class="page-title">
    <h1>Страница калькулятора</h1>
</div>

<div class="agentcalc">
    <div class="agentcalc__tabs">
        <a href="" class="active" data-target="main">Основной калькулятор</a>
        <a href="" data-target="reverse">Обратный калькулятор</a>
    </div>
    <div class="agentcalc__form">
        <form action="index.php?option=com_agentcalc&view=agentcalc&format=json" method="POST" id="agetntcalcForm" name="agetntcalcForm" class="form-validate">
            <?php foreach($this->form->getFieldsets() as $name => $fieldset) :?>
                <fieldset class="<?=$name?>">
                    <?php foreach ($this->form->getFieldset($name) as $field): ?>
                    <div class="control-group">
                        <div class="control-label"><?=$field->label;?></div>
                        <div class="controls"><?=$field->input;?></div>
                    </div>
                    <?php endforeach;?>
                    <div class="control-group">
                        <button type="submit" class="btn btn-white btn-icon rounded-pill shadow-hover hover-translate-y-n3">
                            <span class="btn-inner--text"><?=JText::_($fieldset->label);?></span>
                        </button>
                    </div>
                </fieldset>
            <?php endforeach;?>
            <input type="hidden" name="task" value="">
            <?php echo Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
        </form>
        <form action="index.php?option=com_agentcalc&view=agentcalc&format=json" method="POST" id="calcForm" name="calcForm" class="form-validate is-hidden">
            <?php foreach($this->calc->getFieldsets() as $name => $fieldset) :?>
                <fieldset class="<?=$name?>">
                    <?php foreach ($this->calc->getFieldset($name) as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?=$field->label;?></div>
                            <div class="controls"><?=$field->input;?></div>
                        </div>
                    <?php endforeach;?>
                    <div class="control-group">
                        <button type="submit" class="btn btn-white btn-icon rounded-pill shadow-hover hover-translate-y-n3">
                            <span class="btn-inner--text"><?=JText::_($fieldset->label);?></span>
                        </button>
                    </div>
                </fieldset>
            <?php endforeach;?>
            <input type="hidden" name="task" value="">
            <?php echo Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
        </form>
    </div>
</div>

<table id="credit-table" class="agentcalc__table">
    <thead>
        <tr>
            <th>Срок, месяц</th>
            <th>Стоимость предмета Лизинга</th>
            <th>Количество последующих платежей</th>
            <th>Ежемесячный платеж</th>
            <th>Итоговый платеж</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>