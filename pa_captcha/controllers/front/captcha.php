<?php

/**
 * Copyright PrestashopAddon.com
 * Email: contact@prestashopaddon.com
 * First created: 27/11/2015
 * Last updated: NOT YET
 */
if (!defined('_PS_VERSION_'))
    exit;
class Pa_captchaCaptchaModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        $this->create_image();
        die;
    }
    public function create_image()
    {


        if (Configuration::get('PA_CAPTCHA_TYPE') == 'basic') {
            $num1 = rand(1, 9);
            $num2 = rand(1, 9);
            $security_code = $num1 . "+" . $num2;

            $success_code = intval($num1) + intval($num2);
            $context = Context::getContext();
            if (Tools::getValue('page') == 'contact')
                $this->context->cookie->security_capcha_code_contact = base64_encode($success_code);

            else
                $this->context->cookie->security_capcha_code_registration = base64_encode($success_code);
            // $context->cookie->securitysuccess = base64_encode($security_code) ;
            $context->cookie->write();

            $width = 100;
            $height = 30;
            $image = ImageCreate($width, $height);
            $white = ImageColorAllocate($image, 255, 255, 255);
            $black = ImageColorAllocate($image, 220, 20, 60);
            $background_color = imagecolorallocate($image, 255, 255, 255);
            $text_color = imagecolorallocate($image, 220, 20, 60);

            imagestring($image, 10, 30, 6, $security_code, $black);
        } elseif (Configuration::get('PA_CAPTCHA_TYPE') == 'colorful') {


            $security_code = substr(sha1(mt_rand()), 17, 6);
            $context = Context::getContext();
            if (Tools::getValue('page') == 'contact')
                $this->context->cookie->security_capcha_code_contact = base64_encode($security_code);

            else
                $this->context->cookie->security_capcha_code_registration = base64_encode($security_code);
            $context->cookie->write();

            $image = imagecreatetruecolor(150, 35);

            $width = imagesx($image);
            $height = imagesy($image);

            $black = imagecolorallocate($image, 0, 0, 0);
            $white = imagecolorallocate($image, 255, 255, 255);
            $red = imagecolorallocatealpha($image, 255, 0, 0, 75);
            $green = imagecolorallocatealpha($image, 0, 255, 0, 75);
            $blue = imagecolorallocatealpha($image, 0, 0, 255, 75);

            //          $font = 'arial.ttf';
            // ImageString($image, 5, 30, 4, $security_code, $white);
            //  imagettftext($image, 20, 0, 10, 20, $white, $font, $security_code);

            imagefilledrectangle($image, 0, 0, $width, $height, $white);
            imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $red);
            imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $green);
            imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $blue);
            imagefilledrectangle($image, 0, 0, $width, 0, $black);
            imagefilledrectangle($image, $width - 1, 0, $width - 1, $height - 1, $black);
            imagefilledrectangle($image, 0, 0, 0, $height - 1, $black);
            imagefilledrectangle($image, 0, $height - 1, $width, $height - 1, $black);

            imagestring($image, 10, intval(($width - (strlen($security_code) * 9)) / 2), intval(($height - 15) / 2), $security_code, $black);
        } elseif (Configuration::get('PA_CAPTCHA_TYPE') == 'complex') {

            $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQR';
            $security_code = substr(str_shuffle($permitted_chars), 0, 6);

            $context = Context::getContext();
            if (Tools::getValue('page') == 'contact')
                $this->context->cookie->security_capcha_code_contact = base64_encode($security_code);
            else
                $this->context->cookie->security_capcha_code_registration = base64_encode($security_code);
            // $context->cookie->securitysuccess = base64_encode($security_code) ;
            $context->cookie->write();

            $width = 100;
            $height = 30;
            $image = ImageCreate($width, $height);
            $white = imagecolorallocate($image, 255, 255, 255);
            $black = imagecolorallocate($image, 0, 0, 0);
            $noise_color = imagecolorallocate($image, 100, 120, 180);
            $background_color = imagecolorallocate($image, 255, 255, 255);
            $text_color = imagecolorallocate($image, 20, 40, 100);
            // $fontSize = $height * 0.75;

            //  imagettftext($image, 20, 0, 11, 21, $black, $security_code);

            // imagettftext($image, $font_size, $angle, $x, $y, $text_color, '$font-family', $text);

            ImageFill($image, 0, 0, $background_color);
            
            for ($i = 0; $i < ($width * $height) / 3; $i++) {
                imagefilledellipse($image, mt_rand(0, $width), mt_rand(0, $height), 1, 1, $noise_color);
            }
            for ($i = 0; $i < ($width * $height) / 150; $i++) {
                imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $noise_color);
            }
            // imagettftext($image, $fontSize, 0, $x, $y, $textColor, '../FFF.ttf', $security_code);
            // imagestring($image, $fontSize, 30, intval(($height - 15) / 1.5), $security_code, $black);
            // putenv('GDFONTPATH='.realpath(getenv("SCRIPT_FILENAME")));
            // imagettftext($image, 10, 0, 30, 30, $black, 'FFF.ttf', $security_code);
            // Add the text
            // $this->phpcaptcha($security_code,'#162453','#fff',120,40,10,25);
            $font = dirname(__FILE__) . '/../../font/Lato-Bold.ttf';
            imagettftext($image, 15, 0, 20, 20, $black, $font, $security_code);
        }

        header('Content-type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);;
        exit();
    }

    //W3schools.com captcha
    // public function phpcaptcha($text, $textColor,$backgroundColor,$imgWidth,$imgHeight,$noiceLines=0,$noiceDots=0,$noiceColor='#162453')
    // {   
    //     /* Settings */      
    //     $font = dirname(__FILE__).'/../../font/monofont.ttf';/* font */
    //     $textColor=$this->hexToRGB($textColor); 
    //     $fontSize = $imgHeight * 0.005;

    //     $im = imagecreatetruecolor($imgWidth, $imgHeight);  
    //     $textColor = imagecolorallocate($im, $textColor['r'],$textColor['g'],$textColor['b']);          

    //     $backgroundColor = $this->hexToRGB($backgroundColor);
    //     $backgroundColor = imagecolorallocate($im, $backgroundColor['r'],$backgroundColor['g'],$backgroundColor['b']);

    //     /* generating lines randomly in background of image */
    //     if($noiceLines>0){
    //     $noiceColor=$this->hexToRGB($noiceColor);   
    //     $noiceColor = imagecolorallocate($im, $noiceColor['r'],$noiceColor['g'],$noiceColor['b']);
    //     for( $i=0; $i<$noiceLines; $i++ ) {             
    //         imageline($im, mt_rand(0,$imgWidth), mt_rand(0,$imgHeight),
    //         mt_rand(0,$imgWidth), mt_rand(0,$imgHeight), $noiceColor);
    //     }}              

    //     if($noiceDots>0){/* generating the dots randomly in background */
    //     for( $i=0; $i<$noiceDots; $i++ ) {
    //         imagefilledellipse($im, mt_rand(0,$imgWidth),
    //         mt_rand(0,$imgHeight), 3, 3, $textColor);
    //     }}      

    //     imagefill($im,0,0,$backgroundColor);    
    //     list($x, $y) = $this->ImageTTFCenter($im, $text, $font, $fontSize); 
    //     imagettftext($im, $fontSize, 0, $x, $y, $textColor, $font, $text);      

    //     imagejpeg($im,NULL,90);/* Showing image */
    //     header('Content-Type: image/jpeg');/* defining the image type to be shown in browser widow */
    //     imagedestroy($im);/* Destroying image instance */
    //     die;
    // }

    /*function to convert hex value to rgb array*/
    // protected function hexToRGB($colour)
    // {
    //     if ( $colour[0] == '#' ) {
    //         $colour = substr( $colour, 1 );
    //     }
    //     if ( strlen( $colour ) == 6 ) {
    //         list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
    //     } elseif ( strlen( $colour ) == 3 ) {
    //         list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
    //     } else {
    //         return false;
    //     }
    //     $r = hexdec( $r );
    //     $g = hexdec( $g );
    //     $b = hexdec( $b );
    //     return array( 'r' => $r, 'g' => $g, 'b' => $b );
    // }


    /*function to get center position on image*/
    // protected function ImageTTFCenter($image, $text, $font, $size, $angle = 8) 
    // {
    //     $xi = imagesx($image);
    //     $yi = imagesy($image);
    //     $box = imagettfbbox($size, $angle, $font, $text);
    //     $xr = abs(max($box[2], $box[4]))+5;
    //     $yr = abs(max($box[5], $box[7]));
    //     $x = intval(($xi - $xr) / 2);
    //     $y = intval(($yi + $yr) / 2);
    //     return array($x, $y);   
    // } 
    //     header("Content-Type: image/jpeg"); 
    //     ImageJpeg($image); 
    //     ImageDestroy($image); 
    //     exit();
    // }   

}
