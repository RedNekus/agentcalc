<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Document\Document;

defined('_JEXEC') or exit();
class AgentcalcViewItem extends JViewLegacy {

    protected $form;
    protected  JObject|bool $item;

    public function display($tpl = null): void
    {
        $app = Factory::getApplication();
        $wa = $app->getDocument()->getWebAssetManager();

        if (!$wa->assetExists('script', 'keyselectmodal'))
        {
            $this->addToolBar();
            $document = Factory::getDocument();
            $this->setDocument($document);
            $this->form = $this->get('Form');
            $this->item = $this->get('Item') ?? null;
            parent::display($tpl);
        }
    }

    protected function addToolBar() {
        JToolbarHelper::title(JText::_('COM_AGENTCALC_MANAGER_ITEM_NEW'));

        JToolbarHelper::save("item.save");
        JToolbarHelper::cancel('item.cancel');
    }

    public function setDocument(Document $document): void
    {
        $document->setTitle(JText::_('COM_AGENTCALC_ADMINISTRATION'));
    }
}