<?php
class pcbuilderAssemblyModuleFrontController extends ModuleFrontController
{
  public function initContent()
  {
    parent::initContent();
    $sql = "SELECT * FROM "._DB_PREFIX_."category where active = 1";
	$categorys = Db::getInstance()->ExecuteS($sql);
	/*var_dump($categorys);
	die();  */
	
    $this->setTemplate('assembly.tpl');
  }
}