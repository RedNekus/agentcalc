<?php
defined('_JEXEC') or exit();
Joomla\CMS\HTML\HTMLHelper::_('behavior.formvalidator');
?>
<h1>Страница калькулятора</h1>
<form action="index.php?option=com_agentcalc&view=agentcalc&format=json" method="POST" id="agetntcalcForm" name="agetntcalcForm" class="form-validate">
    <div class="form-horizontal">
        <?php foreach($this->form->getFieldsets() as $name => $fieldset) :?>
            <fieldset class="adminform">
                <legend><?=JText::_($fieldset->label);?></legend>
                <div class="row-fluid row">
                    <div class="col-6">
                        <?php foreach ($this->form->getFieldset($name) as $field): ?>
                            <div class="control-group">
                                <div class="control-label"><?=$field->label;?></div>
                                <div class="controls"><?=$field->input;?></div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </fieldset>
        <?php endforeach;?>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

    <input type="hidden" name="task" value="">
    <?php echo Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
</form>

<table class="agentcalc__">
    <thead>
        <tr>
            <th>Срок, месяц</th>
            <th>Стоимость предмета Лизинга</th>
            <th>Количество последующих платежей</th>
            <th>Ежемесячный платеж</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>