<?php
/*
* 2007-2016 PrestaShop
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
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class shtsplashcategories extends Module
{
	public function __construct()
	{
		$this->name = 'shtsplashcategories';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'SHT';
		$this->need_instance = 0;
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Sht splash categories');
		$this->description = $this->l('Afficher une list des catégories.');
		$this->tab = 'Admin';
        $this->tabParentName = 'AdminSHT';
	}
	     public function createTabs(){


        $var = 'AdminSHT';
        $query = 'SELECT COUNT(id_tab) as Cid from `' . _DB_PREFIX_ .'tab` where class_name="'.$var.'"';
            $payments = Db::getInstance()->ExecuteS($query);
          
            foreach ($payments as $payment ) 
                {
                    if ($payment['Cid'] > 0) 
                    {
                        $tab = new Tab();
                        $tab->name[$this->context->language->id] = $this->l('Add catégorie');
                        $tab->class_name = 'Adminsplachcategories';
                        $tab->id_parent = Tab::getIdFromClassName($this->tabParentName);
                        $tab->module = $this->name;
                        $tab->add();


                 
                        return true;
                    }
                    elseif ($payment['Cid'] == 0) 
                    {

                        $parent_tab = new Tab();
                        $parent_tab->name[$this->context->language->id] = $this->l('SHT');
                        $parent_tab->class_name = 'AdminSHT';
                        $parent_tab->id_parent = 0;
                        $parent_tab->module = $this->name;
                        $parent_tab->add();
                        
                        $tab = new Tab();
                        $tab->name[$this->context->language->id] = $this->l('Add splash catégorie');
                        $tab->class_name = 'Adminsplachcategories';
                        $tab->id_parent = Tab::getIdFromClassName($this->tabParentName);
                        $tab->module = $this->name;
                        $tab->add();

         
                        return true;

                    }
               
                }       
  
    } 

    public function removeTabs($class_name){
        if ($tab_id = (int)Tab::getIdFromClassName($class_name))
        {
            $tab = new Tab($tab_id);
            $tab->delete();
        }
        return true;
    } 
    	public function createTableshtsplashcategories()
	{
		$query='CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ .'shtsplashcategories` (
		    id_shtsplashcategories int NOT NULL AUTO_INCREMENT,
		    titre varchar(255),
		    image_cat varchar(255),
		    link_cat varchar(255),
		    active int DEFAULT "1",
		    PRIMARY KEY (id_shtsplashcategories)
		    )';
		return Db::getInstance()->Execute($query);
	}
	public function DropTableshtsplashcategories()
	{
		$query='drop table `' . _DB_PREFIX_ .'shtsplashcategories`';
		return Db::getInstance()->Execute($query);
	}

	public function install()
	{
		return	parent::install() 
			&& $this->createTabs()
			&& $this->createTableshtsplashcategories() 
			&& $this->registerHook('displayHome') 
			&& $this->registerHook('displayHeader') 
		;
			
	}


	public function uninstall()
	{
		 return $this->removeTabs('Adminsplachcategories') &&
            $this->DropTableshtsplashcategories() &&
            parent::uninstall();
	}
	
	 public function hookDisplayHeader($params)
    {
        $this->context->controller->addCSS($this->_path . 'views/templates/assetes/css/shtsplash.css');
		$this->context->controller->addJS($this->_path.'views/templates/assetes/js/shtsplash.js');

    }


	public function hookDisplayhome($params)
	{

		if (!$this->isCached('shtsplashcategories.tpl', $this->getCacheId()))
		{
			
		$query = 'SELECT * from `' . _DB_PREFIX_ .'shtsplashcategories` ';
        $item = Db::getInstance()->ExecuteS($query);
	
			$this->smarty->assign(array('item' => $item));
	
		}
		return $this->display(__FILE__, 'shtsplashcategories.tpl', $this->getCacheId());

	}




}
