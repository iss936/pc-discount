<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class HighlightItem extends Module
{
	protected static $cache_products;

	public function __construct()
	{
		$this->name = 'highlightitem';
		$this->tab = 'front_office_features';
		$this->version = '1.1.0';
		$this->author = 'ALV';
		$this->need_instance = 0;

		$this->bootstrap = true;
		parent::__construct();

		$this->displayName = $this->l('Feature one item on the home page');
		$this->description = $this->l('Displays one featured item on your homepage.');
	}

	public function install()
	{
		$this->_clearCache('*');
		Configuration::updateValue('HIGHLIGHT_ITEM', 0);

		if (!parent::install()
			|| !$this->registerHook('header')
			|| !$this->registerHook('addproduct')
			|| !$this->registerHook('updateproduct')
			|| !$this->registerHook('deleteproduct')
		)
			return false;

		return true;
	}

	public function uninstall()
	{
		$this->_clearCache('*');

		return parent::uninstall();
	}

	public function getContent()
	{
		$output = '';
		$errors = array();
		if (Tools::isSubmit('submitHomeFeatured'))
		{
			$nbr = Tools::getValue('HIGHLIGHT_ITEM');
			if (!Validate::isInt($nbr) || $nbr <= 0)
			$errors[] = $this->l('The ID of the product is invalid. Please enter a positive number.');

			if (isset($errors) && count($errors))
				$output = $this->displayError(implode('<br />', $errors));
			else
			{
				Configuration::updateValue('HIGHLIGHT_ITEM', (int)$nbr);
				Tools::clearCache(Context::getContext()->smarty, $this->getTemplatePath('highlightitem.tpl'));
				$output = $this->displayConfirmation($this->l('Your settings have been updated.'));
			}
		}

		return $output.$this->renderForm();
	}

	public function hookDisplayHeader($params)
	{
		$this->hookHeader($params);
	}

	public function hookHeader($params)
	{
		if (isset($this->context->controller->php_self) && $this->context->controller->php_self == 'index')
			$this->context->controller->addCSS(_THEME_CSS_DIR_.'product_list.css');
		$this->context->controller->addCSS(($this->_path).'css/highlightitem.css', 'all');
	}

	public function _cacheProducts()
	{
		if (!isset(HighlightItem::$cache_products))
		{
            $id_product = (int)Configuration::get('HIGHLIGHT_ITEM');
            $product = new Product($id_product, false, Context::getContext()->language->id);
            HighlightItem::$cache_products = $product;
		}

		if (HighlightItem::$cache_products === false || empty(HighlightItem::$cache_products))
			return false;
	}

	public function hookDisplayHome($params)
	{
        global $cookie;
		if (!$this->isCached('highlightitem.tpl', $this->getCacheId()))
		{
			$this->_cacheProducts();
            $item = HighlightItem::$cache_products;

            $link = new Link();
            $url = $link->getProductLink($item->id);
            $image = Image::getCover($item->id);
            $price = (round($item->getPrice(true), 2)) . '0';
            $currency = new CurrencyCore($cookie->id_currency);
            $currency_iso = $currency->sign;

            $highlight['name'] = $item->name;
            $highlight['description'] = $item->description;
            $highlight['link'] = $url;
            $highlight['id'] = $item->id;
            $highlight['price'] = $price;
            $highlight['currency'] = $currency_iso;
            $highlight['image'] = Link::getImageLink($item->link_rewrite, $image['id_image'], 'home_default');

			$this->smarty->assign(
				array(
					'product_highlight' => $highlight,
					'homeSize' => Image::getSize(ImageType::getFormatedName('home')),
				)
			);
		}

		return $this->display(__FILE__, 'highlightitem.tpl', $this->getCacheId());
	}

	public function hookDisplayHomeTabContent($params)
	{
		return $this->hookDisplayHome($params);
	}

	public function hookAddProduct($params)
	{
		$this->_clearCache('*');
	}

	public function hookUpdateProduct($params)
	{
		$this->_clearCache('*');
	}

	public function hookDeleteProduct($params)
	{
		$this->_clearCache('*');
	}

	public function hookCategoryUpdate($params)
	{
		$this->_clearCache('*');
	}

	public function _clearCache($template, $cache_id = NULL, $compile_id = NULL)
	{
		parent::_clearCache('highlightitem.tpl');
	}

	public function renderForm()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'description' => $this->l('Here, you can choose the item you want to feature on your home page'),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('ID of the featured item'),
						'name' => 'HIGHLIGHT_ITEM',
						'class' => 'fixed-width-xs',
						'desc' => $this->l('If you don\'t want to feature an item, put "0" in the field'),
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),
		);

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->id = (int)Tools::getValue('id_carrier');
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitHomeFeatured';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(array($fields_form));
	}

	public function getConfigFieldsValues()
	{
		return array(
			'HIGHLIGHT_ITEM' => Tools::getValue('HIGHLIGHT_ITEM', (int)Configuration::get('HIGHLIGHT_ITEM')),
		);
	}
}
