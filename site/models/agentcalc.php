<?php
defined('_JEXEC') or exit();

class AgentcalcModelAgentcalc extends JModelForm {
    public function getForm($data = [], $loadData = true): JForm|bool
    {
        return $this->loadForm('com_agentcalc.agentcalc', 'agentcalc', ['control' => 'jform', 'load_data' => $loadData]) ?? false;
    }
}