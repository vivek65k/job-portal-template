{if isset($is_logged) && $is_logged}
{capture name=path}{l s='Contact'}{/capture}
<h1 class="page-heading bottom-indent">
	{l s='Customer service'} - {if isset($customerThread) && $customerThread}{l s='Your reply'}{else}{l s='Contact us'}{/if}
</h1>
{if isset($confirmation)}
	<p class="alert alert-success">{l s='Your message has been successfully sent to our team.'}</p>
	<p class="alert alert-success">{l s='Our team will get back to you within 10 days.'}</p>
	<ul class="footer_links clearfix">
		<li>
			<a class="btn btn-default button button-small" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}">
				<span>
					<i class="icon-chevron-left"></i>{l s='Home'}
				</span>
			</a>
		</li>
	</ul>
{elseif isset($alreadySent)}
	<p class="alert alert-warning">{l s='Your message has already been sent.'}</p>
	<ul class="footer_links clearfix">
		<li>
			<a class="btn btn-default button button-small" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}">
				<span>
					<i class="icon-chevron-left"></i>{l s='Home'}
				</span>
			</a>
		</li>
	</ul>
{else}
	{include file="$tpl_dir./errors.tpl"}
	<form name="message_form" action="{$request_uri}" method="post" class="contact-form-box" enctype="multipart/form-data">
		<input type="hidden" name="csrf_token" value="{$csrf_token}">
		<fieldset>
			<h3 class="page-subheading">{l s='send a message'}</h3>
			<div class="clearfix">
				<div class="col-xs-12 col-md-3">
					<div class="form-group">
						<label>Subject Heading *</label>
						<select id="id_complaints_category" class="form-control" name="id_complaints_category">
							<option value="0" selected>-- Choose --</option>
							{foreach from=$contacts item=contact}
								<option value="{$contact.id_reason|intval}" rel="{$contact.id_reason|intval}">{$contact.reason|escape:'html':'UTF-8'}</option>
							{/foreach}
						</select>
					</div>
					<div class="form-group">
						<label>Sub Heading *</label>
						<select id="id_sub_complaints_category" class="form-control" name="id_sub_complaints_category">
							<option value="0" selected>-- Choose --</option>
							{foreach from=$sub_contacts item=contact}
								<option class="{$contact.id_parent|intval}" value="{$contact.id_reason|intval}">{$contact.reason|escape:'html':'UTF-8'}</option>
							{/foreach}
						</select>
					</div>
					<p class="form-group" style="display:none">
						<label for="email">{l s='Userid'}</label>
						{if isset($customerThread.email)}
							<input class="form-control grey" type="text" id="email" name="from" value="{$customerThread.email|escape:'html':'UTF-8'}" readonly="readonly"/>
						{else}
							<input class="form-control grey validate" type="text" id="email" name="from" data-validate="isEmail" value="{$email|escape:'html':'UTF-8'}" readonly="readonly"/>
						{/if}
					</p>
					{hook h='displayPaCaptcha'}
				</div>
				<div class="col-xs-12 col-md-9">
					<div class="form-group">
						<label for="message">{l s='Message *'}</label>
						<textarea class="form-control" id="message" name="message" onKeyUp="countMessageChars()">{if isset($message)}{$message|escape:'html':'UTF-8'|stripslashes}{/if}</textarea>
						<span class="pull-right">(Maximum 300 Characters). You have <span id="message_char_count">300</span> characters left.</span>
					</div>
				</div>
			</div>
			<div class="submit">
				<button type="submit" name="submitMessage" id="submitMessage" class="button btn btn-default button-medium"><span>{l s='Send'}<i class="icon-chevron-right right"></i></span></button>
			</div>
		</fieldset>
	</form>
{/if}
{addJsDefL name='contact_fileDefaultHtml'}{l s='No file selected' js=1}{/addJsDefL}
{addJsDefL name='contact_fileButtonHtml'}{l s='Choose File' js=1}{/addJsDefL}
{else}
<a>Please </a><a href="/shop/index.php?controller=customer-register" style="font-family:tahoma;font-size:20px;color:rgb(0, 0, 255);">Register</a> <a>or</a> <a href="/shop/index.php?controller=authentication&back=my-account" style="font-family:tahoma;font-size:20px;color:rgb(0, 0, 255);">Login</a> <a>To Contact Us</a>
{/if}
<!--Refreshing Sub Category using Jquery by amanna -->
<script>
	window.onload = function () {
		document.getElementById('id_sub_complaints_category').disabled=true
		document.getElementById('submitMessage').disabled=true;
	}

	$(document).ready(function(){
    var $category = $('select[name=id_complaints_category]'),
        $subcategory = $('select[name=id_sub_complaints_category]');

		$category.change(function(){
			document.getElementById('id_sub_complaints_category').disabled=false;
			document.getElementById('submitMessage').disabled=true;
			var $this = $(this).find(':selected'),
            rel = $this.attr('rel'),
            $set = $subcategory.find('option.' + rel);

			if ($set.size() < 1) {
            $subcategory.val(0);
            return;
			}

			$subcategory.show().find('option').hide();

			$set.show().first().prop('selected', true);
		});
	});
	$("#id_sub_complaints_category").change(function() {
			document.getElementById('submitMessage').disabled=false;
	});

	function countMessageChars() {
	    var text = document.message_form.message.value.trimLeft();
	    document.message_form.message.value = text;
	    if (text.length > 300) {
			document.message_form.message.value = text.substring(0, 300);
		} else {
			document.getElementById("message_char_count").innerHTML = 300 - text.length;
		}
	}

	function validateMessageForm() {
	    var text = document.message_form.message.value.trim();
	    if(text.length) {
	        document.message_form.message.value = text;
	        return true;
	    } else if(text.length>300) {
	        alert("{l s='Message cannot have more than 300 characters.'}");
	    } else {
	        alert("{l s='Message is empty.'}");
	    }
	    return false;
	}
	</script>
