{if !$ps_version_1_6}
    {if $setting_updated}
        <div class="conf">{l s='Setting updated'}</div>
    {/if}
    <form class="defaultForm form-horizontal" enctype="multipart/form-data" method="post" action="{$postUrl}">
        <fieldset>
            <legend><img src="../img/t/AdminTools.gif"/> {l s='Settings'}</legend>
            
            <table id="form" width="500" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <tr>
                        <td width="130" style="height: 35px;"><label>{l s='Enable captcha for contact form'}</label></td>
                        <td>
                            <label class="t" for="PA_CAPTCHA_CONTACT_on"><img title="{l s='Yes'}" alt="Yes" src="../img/admin/enabled.gif"/></label>
                            <input type="radio" {if $PA_CAPTCHA_CONTACT}checked="checked"{/if} value="1" id="PA_CAPTCHA_CONTACT_on" name="PA_CAPTCHA_CONTACT"/>
    						<label class="t" for="PA_CAPTCHA_CONTACT_on">{l s='Yes'}</label>
                            <label for="PA_CAPTCHA_CONTACT_off" class="t"><img style="margin-left: 10px;" title="{l s='No'}" alt="No" src="../img/admin/disabled.gif"/></label>
    						<input type="radio" {if !$PA_CAPTCHA_CONTACT}checked="checked"{/if} value="0" id="PA_CAPTCHA_CONTACT_off" name="PA_CAPTCHA_CONTACT"/>
    						<label class="t" for="PA_CAPTCHA_CONTACT_off">{l s='No'}</label>
                        </td>
                    </tr>
                    <tr>
                        <td width="130" style="height: 35px;"><label>{l s='Enable captcha for registration form'}</label></td>
                        <td>
                            <label class="t" for="PA_CAPTCHA_REGISTRATION_on"><img title="{l s='Yes'}" alt="Yes" src="../img/admin/enabled.gif"/></label>
                            <input type="radio" {if $PA_CAPTCHA_REGISTRATION}checked="checked"{/if} value="1" id="PA_CAPTCHA_REGISTRATION_on" name="PA_CAPTCHA_REGISTRATION"/>
                			<label for="PA_CAPTCHA_REGISTRATION_on" class="t">{l s='Yes'}</label> 
                            <label for="PA_CAPTCHA_REGISTRATION_off" class="t"><img style="margin-left: 10px;" title="{l s='No'}" alt="No" src="../img/admin/disabled.gif"/></label>    						
                			<input type="radio" {if !$PA_CAPTCHA_REGISTRATION}checked="checked"{/if} value="0" id="PA_CAPTCHA_REGISTRATION_off" name="PA_CAPTCHA_REGISTRATION"/>
                			<label for="PA_CAPTCHA_REGISTRATION_off" class="t">{l s='No'}</label>
                        </td>
                    </tr>
                    <tr>
                        <td width="130" style="height: 35px;"><label class="control-label col-lg-3">{l s='Captcha type'}</label></td>
                        <td>
                            {foreach from=$captchaTypes item='type'}
                                <div style="display: inline-block; margin-bottom: 10px;">
                                    <input style="float: left; margin-right: 5px; margin-top: 10px;" type="radio" {if $PA_CAPTCHA_TYPE==$type.type}checked="checked"{/if} name="PA_CAPTCHA_TYPE" id="PA_CAPTCHA_TYPE_{strtoupper($type.type)}" value="{$type.type}" /> <label style="width: auto;" for="PA_CAPTCHA_TYPE_{strtoupper($type.type)}"><img style="border: 1px solid #ccc;" title="{$type.name}" alt="{$type.name}" src="{$pa_img_dir}{$type.type}.png" /></label>
                                </div>
                            {/foreach}                            
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <button class="button" name="submitUpdate" id="module_form_submit_btn" value="1" type="submit">{l s='Save'}</button>
                        </td>
                    </tr>
                </tbody>
            </table>            
        </fieldset>
    </form>
{else}
    {if $setting_updated}
        <div class="alert alert-success">{l s='Setting updated'}</div>
    {/if}
    <form class="defaultForm form-horizontal" enctype="multipart/form-data" method="post" action="{$postUrl}">
        <div class="panel">
            <div class="panel-heading"><i class="icon-cogs"></i> {l s='Setting'}</div>
            
            <div class="form-wrapper">
                <div class="form-group">
                    <label class="control-label col-lg-3" for="transition-effect">{l s='Enable captcha for contact form'}</label>
                    <div class="col-lg-9">
                        <span class="switch prestashop-switch fixed-width-lg">
    				        <input type="radio" {if $PA_CAPTCHA_CONTACT}checked="checked"{/if} value="1" id="PA_CAPTCHA_CONTACT_on" name="PA_CAPTCHA_CONTACT"/>
    						<label for="PA_CAPTCHA_CONTACT_on">{l s='Yes'}</label>
    						<input type="radio" {if !$PA_CAPTCHA_CONTACT}checked="checked"{/if} value="0" id="PA_CAPTCHA_CONTACT_off" name="PA_CAPTCHA_CONTACT"/>
    						<label for="PA_CAPTCHA_CONTACT_off">{l s='No'}</label>
    						<a class="slide-button btn"></a>
    					</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3" for="transition-effect">{l s='Enable captcha for registration form'}</label>
                    <div class="col-lg-9">
                        <span class="switch prestashop-switch fixed-width-lg">
                	        <input type="radio" {if $PA_CAPTCHA_REGISTRATION}checked="checked"{/if} value="1" id="PA_CAPTCHA_REGISTRATION_on" name="PA_CAPTCHA_REGISTRATION"/>
                			<label for="PA_CAPTCHA_REGISTRATION_on">{l s='Yes'}</label>
                			<input type="radio" {if !$PA_CAPTCHA_REGISTRATION}checked="checked"{/if} value="0" id="PA_CAPTCHA_REGISTRATION_off" name="PA_CAPTCHA_REGISTRATION"/>
                			<label for="PA_CAPTCHA_REGISTRATION_off">{l s='No'}</label>
                			<a class="slide-button btn"></a>
                		</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">{l s='Captcha type'}</label>
                    <div class="col-lg-9">
                        {foreach from=$captchaTypes item='type'}
                            <input type="radio" {if $PA_CAPTCHA_TYPE==$type.type}checked="checked"{/if} name="PA_CAPTCHA_TYPE" id="PA_CAPTCHA_TYPE_{strtoupper($type.type)}" value="{$type.type}" /> <label style="width: auto;" for="PA_CAPTCHA_TYPE_{strtoupper($type.type)}"><img style="border: 1px solid #ccc;" title="{$type.name}" alt="{$type.name}" src="{$pa_img_dir}{$type.type}.png" /></label> <br />
                        {/foreach}
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button class="btn btn-default pull-right" name="submitUpdate" id="module_form_submit_btn" value="1" type="submit">
        		  <i class="process-icon-save"></i> {l s='Save'}
        	    </button>																								
            </div>
        </div>
    </form>
{/if}