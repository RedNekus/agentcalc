<?php

use Joomla\CMS\Factory;

defined('_JEXEC') or exit();

class AgentcalcModelAgentcalc extends JModelList {
    public function getForm($data = [], $loadData = true): JForm|bool
    {
        return $this->loadForm('com_agentcalc.agentcalc', 'agentcalc', ['control' => 'jform', 'load_data' => $loadData]) ?? false;
    }
    protected function getListQuery(): string
    {
        $db    = Factory::getContainer()->get('DatabaseDriver');
        $query = $db->getQuery(true);

        $query->select([...array_map([$db, 'quoteName'],[
            'settings.id',
            'settings.term',
            'settings.remuneration'])
        ]);

        $query->from($db->quoteName('#__agentcalc_settings', 'settings'));

        $orderCol	= 'term';
        $orderDirn 	= 'DESC';

        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
        return $query;
    }
}