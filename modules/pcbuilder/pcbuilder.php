<?php
if (!defined('_PS_VERSION_'))
  exit;
 
class Pcbuilder extends Module
{
  public function __construct()
  {
    $this->name = 'pcbuilder';
    $this->tab = 'Test';
    $this->version = 1.0;
    $this->author = 'Soumare Issa';
    $this->need_instance = 0;
    $this->bootstrap = true;

    parent::__construct();
 
    $this->displayName = $this->l('Pc builder');
    $this->description = $this->l('Assembler votre Pc.');
    $this->confirmUninstall = $this->l('Voulez-vous vraiment supprimer ce module');
    if (!Configuration::get('pcbuilder'))      
      $this->warning = $this->l('No name provided');
  }
 
  /**
   * 
   * 
   * @return boolean
   */
  public function install()
  {
    if (Shop::isFeatureActive())
      Shop::setContext(Shop::CONTEXT_ALL);
   
    if (!parent::install() ||
      !$this->registerHook('leftColumn') ||
      !$this->registerHook('header') ||
      !Configuration::updateValue('pcbuilder', 'salut')
    )
      return false;
   
    return true;
  }

  public function hookDisplayLeftColumn($params)
  {
      $this->context->smarty->assign(
        array(
            'pcbuilder' => Configuration::get('pcbuilder'),
            'pcbuilder_link' => $this->context->link->getModuleLink('pcbuilder','assembly')
          )
        );
      return $this->display(__FILE__, '/views/templates/front/pcbuilder.tpl');
  }

  public function hookDisplayRightColumn($params)
  {
    return $this->hookDisplayLeftColumn($params);
  }

  public function hookDisplayHeader()
  {
    $this->context->controller->addCSS($this->_path.'css/pcbuilder.css', 'all');
  }
}
