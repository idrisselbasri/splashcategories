<?php 
include_once dirname(__FILE__).'/../../classes/shtaddsplachcategorie.php';

class AdminsplachcategoriesController extends ModuleAdminController
{

    protected function l($string, $class = null, $addslashes = false, $htmlentities = true)
    {
        if ( _PS_VERSION_ >= '1.7') {
            return Context::getContext()->getTranslator()->trans($string);
        } else {
            return parent::l($string, $class, $addslashes, $htmlentities);
        }
    }
	public function __construct()
    {
       $this->bootstrap = true;
        $this->table = 'shtsplashcategories';
        $this->className = 'shtaddsplachcategorie';
        $this->lang = false;
        $this->deleted = false;
        $this->_defaultOrderWay = 'ASC';
        $this->explicitSelect = true;
        $this->context = Context::getContext();
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->bulk_actions = array(
            'delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')),
            /*'affectzone' => array('text' => $this->l('Assign to a new zone'))*/
        );

        $this->fields_list = array(
            'id_shtsplashcategories' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'titre' => array(
                'title' => $this->l('Titre'),
                'filter_key' => 'a!titre'
            ),
            'image_cat' => array(
                'title' => $this->l('Image Categorie'),
                'width' => 70,
                // 'image' => $this->image_dir
                'filter_key' => 'a!image_cat'
            ),
            'link_cat' => array(
                'title' => $this->l('Link image banner'),
                'filter_key' => 'a!link_cat'
            ),
            'active' => array(
                'title' => $this->l('Active'),
                'align' => 'center',
                'active' => 'status',
                'type' => 'bool',
                'orderby' => false,
                'filter_key' => 'a!active',
                'class' => 'fixed-width-sm'
            )
        );
       
        parent::__construct();
    }
    public function initPageHeaderToolbar()
    {
        if (empty($this->display)) {
            $this->page_header_toolbar_btn['new_banner'] = array(
                'href' => self::$currentIndex.'&addshtsplashcategories&token='.$this->token,
                'desc' => $this->l('Ajouter une Banner ', null, null, false),
                'icon' => 'process-icon-new'
            );
        }

        parent::initPageHeaderToolbar();
    }

       public function postProcess()
    {
       
        $obj = $this->loadObject(true);
        $errors = "";

        $_POST['image_cat']=$obj->image_cat;
        if (  isset($_FILES['image_cat']) && isset($_FILES['image_cat']['tmp_name']) && !empty($_FILES['image_cat']['tmp_name'])) {
                        if ($error = ImageManager::validateUpload($_FILES['image_cat'], Tools::convertBytes(ini_get('upload_max_filesize')))) {
                            $errors[] = $error;
                        }
                        else {
                            $imageName = explode('.', $_FILES['image_cat']['name']);
                            $imageExt = $imageName[1];
                            $imageName = $imageName[0];
                            $image_cat = strtolower($imageName).'-'.rand(0,1000).'.'.$imageExt;

                            if (!move_uploaded_file($_FILES['image_cat']['tmp_name'],_PS_MODULE_DIR_ .'shtsplashcategories/img/' . $image_cat)) {
                                $errors[] = $this->l('File upload error.');
                            }
                            else{
                                $img_old = _PS_STORE_IMG_DIR_ . $_FILES['image_cat']['name'] . $obj->image_cat;
                                if (file_exists($img_old))
                                    unlink($img_old);
                                move_uploaded_file($_FILES['image_cat']['tmp_name'],_PS_MODULE_DIR_ .'shtsplashcategories/img/'. $image_cat);
                                $_POST['image_cat'] = $image_cat;
                            }
                        }
   
        }

        $return = parent::postProcess();
        return $return;
    }

    public function renderForm()
    {

        if (!($obj = $this->loadObject(true))) {
            return;
        }

           
        if (Validate::isLoadedObject($this->object))
            $image_cat = '<br/>
                        <img id="image_desc" style="clear:both;width: 250px; height:250px;" alt="" src="'.__PS_BASE_URI__.'modules/shtsplashcategories/img/' . $obj->image_cat .'" />
                        <br/>';
        else {
            $image_cat = '';
        }

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Les items SoftHighTech'),
                'icon' => 'icon-globe'
            ),

            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Titre'),
                    'name' => 'titre',
                    'desc' => $this->l('Enter Your Post Meta Keyword. Separated by comma(,)')
                ),
                array(
                    'type' => 'file',
                    'label' => $this->l('Image Description'),
                    //'id' => 'idfile',
                    'name' => 'image_cat',
                    'required' => true,
                    'desc'  =>  $this->l('Extension allowed: jpeg, png, jpg.'),
                    'image' => $image_cat ? $image_cat: false,
                    'display_image' => true,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Link Categorie'),
                    'name' => 'link_cat',
                    'required' => true,
                    'options' => array(
                        'query' =>shtaddsplachcategorie::getAllcat(),
                        'id' => 'link_rewrite',
                        'name' => 'value'
                      )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Active'),
                    'name' => 'active',
                    'required' => false,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => '<img src="../img/admin/enabled.gif" alt="'.$this->l('Yes').'" title="'.$this->l('Yes').'" />'.$this->l('Yes')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => '<img src="../img/admin/disabled.gif" alt="'.$this->l('No').'" title="'.$this->l('No').'" />'.$this->l('No')
                        )

                    )
                )
            )

        );

        if (Shop::isFeatureActive()) {
            $this->fields_form['input'][] = array(
                'type' => 'shop',
                'label' => $this->l('Shop association'),
                'name' => 'checkBoxShopAsso',
            );
        }

  
        $this->fields_form['submit'] = array(
            'title' => $this->l('Save')
        );
       $this->addJqueryUI('ui.datepicker');
        
        return parent::renderForm();
    }
    
	
}