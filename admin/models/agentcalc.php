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
        echo $query->dump();
        die();
        return $query;
    }

    public function getCompanyRates() {
        $json = file_get_contents('php://input');
        $data = (object)json_decode($json, true);
        $agent_id = $data->agent;

        $db    = Factory::getContainer()->get('DatabaseDriver');
        $query = $db->getQuery(true);
        $query->select([...array_map([$db, 'quoteName'],['settings.term'])]);

        $subQuery =$db->getQuery(true);
        $subQuery->select($db->quoteName('s.remuneration'));
        $subQuery->from($db->quoteName('#__agentcalc_settings', 's'));
        $subQuery->where($db->quoteName('settings.term') . ' = ' . $db->quoteName('s.term'));
        $subQuery->order($db->quoteName('s.company_id') .' DESC');
        $subQuery->setLimit(1);

        $query->select('(' . $subQuery->__toString() . ') AS `remuneration`');

        $subQuery2 =$db->getQuery(true);
        $subQuery2->select($db->quoteName('c.id'));
        $subQuery2->from($db->quoteName('#__pcpartners_companies', 'c'));
        $subQuery2->join('LEFT', '#__fields_values AS `fields` ON `fields`.item_id = '. $agent_id .' AND `fields`.`field_id` = 29');
        $subQuery2->where($db->quoteName('c.id') . ' = ' . $db->quoteName('fields.value'));
        $subQuery2->setLimit(1);

        $query->from($db->quoteName('#__agentcalc_settings', 'settings'));
        $query->where($db->quoteName('settings.company_id') . ' = (' . $subQuery2->__toString() . ') OR ' . $db->quoteName('settings.company_id') . ' IS NULL');

        $orderCol	= 'term';
        $orderDirn 	= 'ASC';

        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
        $db->setQuery($query);
        return $db->loadObjectList();
    }
}