<?php 

class shtaddsplachcategorie extends ObjectModel
{ 
  
    public $id_shtsplashcategories ;  
    public $titre ; 
    public $image_cat ;
    public $link_cat ;
    public $active ;
	
    /**
     * @see ObjectModel::$definition
     */
	public static $definition = array(
        'table' => 'shtsplashcategories',
        'primary' => 'id_shtsplashcategories',
        'multilang' => false,
        'fields' => array(
            'id_shtsplashcategories' =>   array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'titre' =>  array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'image_cat' =>  array('type' => self::TYPE_STRING, 'validate' => 'isString'), 
            'link_cat' =>  array('type' => self::TYPE_STRING,  'validate' => 'isString'),         
            'active' =>            array('type' => self::TYPE_BOOL, 'validate' => 'isBool')
        )
    );


      public static function getAllcat(){
        $id_shop = (int)Shop::getContextShopID();   
        $id_lang = (int)Context::getContext()->language->id;
        $query = 'SELECT  CONCAT(a.`id_category`, "-", `link_rewrite`) AS link_rewrite ,`name`
                FROM `ps_category` a 
                LEFT JOIN `ps_category_lang` b ON (b.`id_category` = a.`id_category` AND b.`id_lang` = "'.$id_lang.'" 
                AND b.`id_shop` = "'.$id_shop.'")
                LEFT JOIN `ps_category_shop` sa ON (a.`id_category` = sa.`id_category` AND sa.`id_shop` = "'.$id_shop.'")  
                ORDER BY sa.`position` ASC';

        $cats_res = Db::getInstance()->ExecuteS($query);
        //var_dump($cats_res);
        //die();

        $cats = array();
        foreach ($cats_res as $row) 
        {

            $cats[]=array('link_rewrite' => $row['link_rewrite'], 'value' => $row['name'] ); 

        }
        return $cats;
        }
}