<?php
use Joomla\CMS\Factory;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

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
        $db     = Factory::getContainer()->get('DatabaseDriver');
        $lead_id = (int)$_REQUEST['lead_id'];
        if(!empty($lead_id)) {
            $userQuery  = $db->getQuery(true);
            $userQuery->select($db->quoteName('agent_id'));
            $userQuery->from($db->quoteName('#__pcpartners_leads', 'leads'));
            $userQuery->where( $db->quoteName('leads.id') . ' = ' . $lead_id);
            $db->setQuery($userQuery);
            $res = $db->loadObject();
            $userId = (int)$res->agent_id;
            if(!empty($userId)) {
                $user = Factory::getUser($userId);
            }
        } else {
            $user = Factory::getUser();
            $userId = $user->get('id');
        }
        $customFields = FieldsHelper::getFields('com_users.user',$user, true);
        $values = array_column($customFields, 'rawvalue', 'name');
        $company_id = (int)$values['company'];
        $query  = $db->getQuery(true);
        $query->select($db->quoteName('companies.max_term'));
        $query->from($db->quoteName('#__pcpartners_companies', 'companies'));
        $query->join('LEFT', $db->quoteName('#__fields_values', 'fields') . ' ON ' . $db->quoteName('companies.id') . ' = ' . $db->quoteName('fields.value'));
        $query->where( $db->quoteName('fields.item_id') . ' = ' . $userId . ' AND ' . $db->quoteName('fields.field_id').' = ' . $db->quote('29') );
        $db->setQuery($query);
        $res = $db->loadObject();
/*
        $subQuery = $db->getQuery(true)
            ->select("s.remuneration")
            ->from($db->quoteName("#__agentcalc_settings", "s"))
            ->where("`settings`.term = s.term  AND (s.company_id = {$company_id} OR s.company_id IS NULL)")
            ->order("s.company_id DESC")
            ->setLimit(1);
        $subQueryId = $db->getQuery(true)
            ->select("s.id")
            ->from($db->quoteName("#__agentcalc_settings", "s"))
            ->where("`settings`.term = s.term  AND (s.company_id = {$company_id} OR s.company_id IS NULL)")
            ->order("s.company_id DESC")
            ->setLimit(1);
*/
        $query = $db->getQuery(true);

        $query->select([
            "id",
            'term',
            'MAX(`settings`.`company_id`) AS `company_id`',
            'remuneration'
        ]);

        $query->from($db->quoteName('#__agentcalc_settings', 'settings'));
        if($res->max_term) {
            $query->where( $db->quoteName('settings.term') . ' <=' . $res->max_term);
        }
        if ($company_id) {
            $query->where( "(" . $db->quoteName('settings.company_id') . ' =' . $company_id . ' OR ' . $db->quoteName('settings.company_id') . ' IS NULL)');
        } else {
            $query->where( "(" . $db->quoteName('settings.company_id') . ' IS NULL)');
        }

        $query->group('settings.term');

        $orderCol	= 'term';
        $orderDirn 	= 'ASC';

        if($company_id) {
            $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn) . ", `settings`.`company_id` DESC");
        } else {
            $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn) );
        }
        //echo $query;
        //die();
        return $query;
    }
}