<?php

use Joomla\CMS\Factory;

defined('_JEXEC') or exit();

class AgentcalcModelAgentcalc extends JModelList {
    public function getForm($data = [], $loadData = true): JForm|bool
    {
        return $this->loadForm('com_agentcalc.agentcalc', 'agentcalc', ['control' => 'jform', 'load_data' => $loadData]) ?? false;
    }
    public function getCalc($data = [], $loadData = true): JForm|bool
    {
        return $this->loadForm('com_agentcalc.calc', 'calc', ['control' => 'jform', 'load_data' => $loadData]) ?? false;
    }
    protected function getListQuery(): string
    {
        $user   = Factory::getUser();
        $userId = $user->get('id');
        $db     = Factory::getContainer()->get('DatabaseDriver');
        $query  = $db->getQuery(true);

        $query->select($db->quoteName('companies.max_term'));
        $query->from($db->quoteName('#__pcpartners_companies', 'companies'));
        $query->join('LEFT', $db->quoteName('#__fields_values', 'fields') . ' ON ' . $db->quoteName('companies.id') . ' = ' . $db->quoteName('fields.value'));
        $query->where( $db->quoteName('fields.item_id') . ' = ' . $userId . ' AND ' . $db->quoteName('fields.field_id').' = ' . $db->quote('29') );
        $db->setQuery($query);
        $res = $db->loadObject();

        $query = $db->getQuery(true);
        $query->select([...array_map([$db, 'quoteName'],[
            'settings.id',
            'settings.term',
            'settings.remuneration'])
        ]);

        $query->from($db->quoteName('#__agentcalc_settings', 'settings'));
        if($res->max_term) {
            $query->where( $db->quoteName('settings.term') . ' <=' . $res->max_term);
        }

        $orderCol	= 'term';
        $orderDirn 	= 'ASC';

        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
        return $query;
    }
}