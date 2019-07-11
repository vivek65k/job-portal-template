<?php
/**
 * Copyright PrestashopAddon.com
 * Email: contact@prestashopaddon.com
 * First created: 27/11/2015
 * Last updated: NOT YET
*/
if (!defined('_PS_VERSION_'))
	exit;
/**
 * Includes 
 */   
class Pa_captcha extends Module
{    
    private $_hooks = array('displayPaCaptcha','displayHeader','displayCustomerAccountForm');
    public function __construct()
	{
		$this->name = 'pa_captcha';
		$this->tab = 'front_office_features';
		$this->version = '1.0.1';
		$this->author = 'PrestashopAddon.com';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Captcha PRO');
		$this->description = $this->l('Add captcha security to contact form and customer registration form. Protect your website from spam contacts and spam customer accounts');
		$this->ps_versions_compliancy = array('min' => '1.5.0.0', 'max' => _PS_VERSION_);
    }
     /**
	 * @see Module::install()
	 */
    public function install()
	{	    
	    $res = parent::install();        
        foreach($this->_hooks as $hook)
        {
            $res &= $this->registerHook($hook);
        }  
        Configuration::updateValue('PA_CAPTCHA_CONTACT',1); 
        Configuration::updateValue('PA_CAPTCHA_REGISTRATION',1);   
        Configuration::updateValue('PA_CAPTCHA_TYPE','basic'); 
        return $res;
    }
    /**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
	    Configuration::deleteByName('PA_CAPTCHA_CONTACT');
        Configuration::deleteByName('PA_CAPTCHA_REGISTRATION');
        Configuration::deleteByName('PA_CAPTCHA_TYPE');
        return parent::uninstall();
    }
    public function hookDisplayHeader()
    { 
        $this->context->controller->addCSS($this->_path.'css/pa-captcha.css', 'all');        
    }
    public function getContent()
    {
        if(Tools::isSubmit('submitUpdate'))
        {
            Configuration::updateValue('PA_CAPTCHA_CONTACT', (int)Tools::getValue('PA_CAPTCHA_CONTACT') ? 1 : 0);
            Configuration::updateValue('PA_CAPTCHA_REGISTRATION', (int)Tools::getValue('PA_CAPTCHA_REGISTRATION') ? 1 : 0);
            Configuration::updateValue('PA_CAPTCHA_TYPE', strtolower(trim(Tools::getValue('PA_CAPTCHA_TYPE'))));
        }
        if(version_compare(_PS_VERSION_, '1.6.0', '>='))
            $postUrl = $this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        else
            $postUrl = AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules');
        $this->smarty->assign(
            array(                
                'PA_CAPTCHA_CONTACT' => (int)Configuration::get('PA_CAPTCHA_CONTACT'),
                'PA_CAPTCHA_REGISTRATION' => (int)Configuration::get('PA_CAPTCHA_REGISTRATION'),
                'PA_CAPTCHA_TYPE' => Configuration::get('PA_CAPTCHA_TYPE'),
                'setting_updated' => Tools::isSubmit('submitUpdate') ? true : false,
                'captchaTypes' => array(
                    array(
                        'type' => 'basic',
                        'name' => $this->l('Basic'),
                    ),
                    array(
                        'type' => 'colorful',
                        'name' => $this->l('Colorful'),
                    ),
                    array(
                        'type' => 'complex',
                        'name' => $this->l('Complex'),
                    ),
                ),
                'pa_img_dir' => $this->_path.'img/',
                'postUrl' => $postUrl,
                'ps_version_1_6' => version_compare(_PS_VERSION_, '1.6.0', '>=') === true ? true : false,
            )
        );        
        return $this->display(__FILE__, 'admin-config.tpl');
    }
    public function hookDisplayPaCaptcha()
    { 
        $rand = md5(rand());
        $page = strtolower(trim(Tools::getValue('controller'))) == 'contact' ? 'contact' : 'registration';
        
        if($page == 'contact' && !(int)Configuration::get('PA_CAPTCHA_CONTACT') || $page != 'contact' && !(int)Configuration::get('PA_CAPTCHA_REGISTRATION'))
            return;
        $this->smarty->assign(array(
            'captcha_page' => $page,

            'captcha_image' => $this->context->link->getModuleLink('pa_captcha', 'captcha', array('page' => $page, 'rand' => $rand)),
            'rand' => $rand,
            
            'ps_version_1_6' => version_compare(_PS_VERSION_, '1.6.0', '>=') === true ? true : false,
        ));        
        return $this->display(__FILE__, 'front-captcha.tpl');
    }
    public function hookDisplayCustomerAccountForm()
    {
        return $this->hookDisplayPaCaptcha();
    }
}