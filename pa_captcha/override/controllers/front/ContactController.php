<?php
/**
 * Copyright PrestashopAddon.com
 * Email: contact@prestashopaddon.com
 * First created: 27/11/2015
 * Last updated: NOT YET
*/

class ContactController extends ContactControllerCore
{    

    /**
    * Start forms process
    * @see FrontController::postProcess()
    */
    public function postProcess()
    {
        if (Tools::isSubmit('submitMessage')) {
            if(!(int)Configuration::get('PA_CAPTCHA_CONTACT'))
            {
                parent::postProcess();
                return;
            }
            $security = strtolower(trim(Tools::getValue('controller'))) == 'contact' ? $this->context->cookie->security_capcha_code_contact : $this->context->cookie->security_capcha_code_registration;
            if($security)
                $security = @base64_decode($security);
            if (strtolower(trim(Tools::getValue('pa_captcha'))) != strtolower($security))
                $this->errors[] = Tools::displayError('Security code dose not match');
            else
                parent::postProcess();
        }
    }
    /**
    * Assign template vars related to page content
    * @see FrontController::initContent()
    */
    public function initContent()
    {
        parent::initContent();
        if(version_compare(_PS_VERSION_, '1.6.0', '>=') === true)
        {
            if(file_exists(_PS_THEME_DIR_.'modules/pa_captcha/views/templates/front/front-contact-form.tpl'))
                $view = _PS_THEME_DIR_.'modules/pa_captcha/views/templates/front/front-contact-form.tpl';
            else
                $view = _PS_MODULE_DIR_.'pa_captcha/views/templates/front/front-contact-form.tpl';
        }
        else
        {
            if(file_exists(_PS_THEME_DIR_.'modules/pa_captcha/views/templates/front/front-contact-form-v_1_5.tpl'))
                $view = _PS_THEME_DIR_.'modules/pa_captcha/views/templates/front/front-contact-form-v_1_5.tpl';
            else
                $view = _PS_MODULE_DIR_.'pa_captcha/views/templates/front/front-contact-form-v_1_5.tpl';
        }
        
        $this->setTemplate($view);
    }
}
