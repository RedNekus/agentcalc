<?php
defined('_JEXEC') or exit();
?>
<h2><?=JText::_('COM_AGENTCALC_SETTINGS_TITLE'); ?></h2>
<form action="index.php?option=com_agentcalc&view=agentcalc" method="post" id="adminForm" name="adminForm">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>
                <?=JText::_('COM_AGENTCALC_SETTINGS_NUM'); ?>
            </th>
            <th><?=JHtml::_('grid.checkall'); ?></th>
            <th>
                <?=JText::_('COM_AGENTCALC_SETTINGS_TERM'); ?>
            </th>
            <th>
                <?=JText::_('COM_AGENTCALC_SETTINGS_REMUNERATION'); ?>
            </th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="5">
                <?php echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php if (!empty($this->items)) { ?>
            <?php foreach ($this->items as $i => $item) {
                ?>
                <tr>
                    <td><?=$this->pagination->getRowOffset($i) ?></td>
                    <td><?=JHtml::_('grid.id', $i, $item->id)?></td>
                    <td><?=$item->term?></td>
                    <td><?=$item->remuneration?></td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo Joomla\CMS\HTML\HTMLHelper::_('form.token'); ?>
</form>

