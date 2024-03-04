<?php

use Joomla\CMS\Factory;

defined('_JEXEC') or exit();

class AgentcalcModelAgentcalc extends JModelList {
    protected function getListQuery(): string
    {
        $db    = Factory::getContainer()->get('DatabaseDriver');
        $query = $db->getQuery(true);

        $query->select([...array_map([$db, 'quoteName'],[
            'settings.id',
            'settings.term',
            'settings.remuneration'])
        ]);
        $query->select(
            'companies.name as company'
        );

        $query->from($db->quoteName('#__agentcalc_settings', 'settings'));
        $query->join('LEFT', '#__pcpartners_companies AS companies ON companies.id = settings.company_id');

        $orderCol	= 'term';
        $orderDirn 	= 'DESC';

        $query->order('company ASC, ' . $db->escape($orderCol) . ' ' . $db->escape($orderDirn));
        return $query;
    }
}