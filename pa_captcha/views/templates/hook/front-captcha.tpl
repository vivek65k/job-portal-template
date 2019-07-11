{if $ps_version_1_6}
    <div class="form-group required page_{$captcha_page} ps_v_16">
        <div class="pa-captcha-field-row">
    		<label for="pa_captcha">{l s='Security code'} {if $captcha_page=='registration'}<sub>*</sub>{/if}</label>
            <span class="pa-captcha-img">
                <img class="pa-captcha-img-data" src="{$captcha_image}" alt="{l s='Security code'}" title="{l s='Security code'}" />
                <span id="pa-captcha-refesh" data-rand="{$rand}"><img title="{l s='Refresh the code'}" alt="{l s='Refresh the code'}" src="{$modules_dir}pa_captcha/img/refresh.png" /></span>
            </span>
        </div>
	<p>{l s='Please enter the above Security Code below.'}</p>
    	<input type="text" name="pa_captcha" id="pa_captcha" class="form-control grey" autocomplete="off" />
    </div>
{else}
    <p class="text page_{$captcha_page} ps_v_15">
        <label for="pa_captcha">{l s='Security code'} {if $captcha_page=='registration'}<sub>*</sub>{/if}</label>
        <span class="pa-captcha-field-cell">    		
            <span class="pa-captcha-img" >
                <img class="pa-captcha-img-data" src="{$captcha_image}" alt="{l s='Security code'}" title="{l s='Security code'}" />
                <span id="pa-captcha-refesh" data-rand="{$rand}"><img title="{l s='Refresh the code'}" alt="{l s='Refresh the code'}" src="{$modules_dir}pa_captcha/img/refresh.png" /></span>
            </span>
            <input type="text" name="pa_captcha" id="pa_captcha"/>
        </span>    	
    </p>
{/if}
<script type="text/javascript">
    {literal}
        $(document).ready(function(){
            $('#pa-captcha-refesh').click(function(){
                originalCapcha = $('.pa-captcha-img-data').attr('src');
                originalCode = $('#pa-captcha-refesh').attr('data-rand');
                newCode = Math.random();
                $('.pa-captcha-img-data').attr('src', originalCapcha.replace(originalCode,newCode));
                $('#pa-captcha-refesh').attr('data-rand', newCode);
            });
        });
    {/literal}
</script>
