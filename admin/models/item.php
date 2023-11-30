<?php
defined('_JEXEC') or exit();
use Joomla\CMS\Table\Table;
use Joomla\CMS\MVC\Model\AdminModel;

class AgentcalcModelItem extends AdminModel {

    public function getForm($data = [], $loadData = true): JForm|bool
    {
        $form = $this->loadForm('com_agentcalc.item', 'item', ['control' => 'jform', 'load_data' => $loadData]);
        if (empty($form))
        {
            return false;
        }

        return $form;
    }

    public function getTable($name = 'Item', $prefix = 'AgentcalcTable', $options =[]): Table|bool
    {
        return parent::getTable($name, $prefix, $options);
    }
    protected function loadFormData(): JObject|bool|array
    {
        return $this->getItem();
    }
}