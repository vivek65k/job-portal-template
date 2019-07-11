<?php
class AuthController extends AuthControllerCore
{
    public function processSubmitAccount()
    {
        if((int)Configuration::get('PA_CAPTCHA_REGISTRATION'))
        {
            $security = $this->context->cookie->security_capcha_code_registration;
            if($security)
                $security = @base64_decode($security);
            if (strtolower(trim(Tools::getValue('pa_captcha'))) != strtolower($security))
                $this->errors[] = Tools::displayError('Security code dose not match');
        }
        parent::processSubmitAccount();
    }

    public function processSubmitLogin()
    {
	 if((int)Configuration::get('PA_CAPTCHA_REGISTRATION'))
	 {
		$security = $this->context->cookie->security_capcha_code_registration;
		if($security)
			$security = @base64_decode($security);
		if (strtolower(trim(Tools::getValue('pa_captcha'))) != strtolower($security))
			$this->errors[] = Tools::displayError('Security code dose not match');
		 else
		      parent::processSubmitLogin();
	 }
    }
}
