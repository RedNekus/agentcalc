<?php
defined('_JEXEC') or exit();

class AgentcalcControllerAgentcalc extends JControllerAdmin
{
    public function getModel($name = 'Item', $prefix = 'AgentcalcModel', $config = []): JModelLegacy|bool
    {
        return parent::getModel($name, $prefix, $config);
    }
}
