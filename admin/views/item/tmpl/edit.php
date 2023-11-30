<?php
defined('_JEXEC') or exit();

Joomla\CMS\HTML\HTMLHelper::_('behavior.formvalidator');
?>
<h2><?php echo JText::_('COM_AGENTCALC_BASE_ITEM')?></h2>
<form action="index.php?option=com_agentcalc&layout=edit&id=<?=$this->item->id ?? "0";?>" method="POST" id="adminForm" name="adminForm" class="form-validate">
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
    </div>

    <input type="hidden" name="task" value="">
    <?php echo Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
</form>
