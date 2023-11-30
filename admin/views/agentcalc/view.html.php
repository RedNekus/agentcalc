<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Document\Document;

defined('_JEXEC') or exit();

class agentcalcViewagentcalc extends JViewLegacy {
    public function display($tpl = null):void
    {
        $app = Factory::getApplication();
        $wa = $app->getDocument()->getWebAssetManager();
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination') ;

        if (!$wa->assetExists('script', 'keyselectmodal'))
        {
            $document = Factory::getDocument();
            parent::display($tpl);
            $this->addToolBar();
            $this->setDocument($document);
        }
    }

    protected function addToolBar(): void
    {
        JToolbarHelper::title(JText::_('COM_AGENTCALC_MANAGER_AGENTCALC'));
        JToolbarHelper::addNew("item.add");
        JToolbarHelper::editList('item.edit');
        JToolbarHelper::deleteList('','agentcalc.delete');
    }
    public function setDocument(Document $document): void
    {
        $document->setTitle(JText::_('COM_AGENTCALC_ADMINISTRATION'));
    }
}