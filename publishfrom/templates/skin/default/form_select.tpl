<p>
	<label for="{$sSelectName}">{$aLang.plugin.publishfrom.publishfrom_label}:</label>
	<select name="{$sSelectName}">
		{if $oTopicEdit}
			{assign var="oTopicUser" value="`$oTopicEdit->getUser()`"}
			{if $oTopicUser}
				<option value="{$oTopicUser->getId()}">
		       			{if $oTopicUser->getProfileName() ne ""}
		       				{$oTopicUser->getProfileName()}
						{else}
			       			{$oTopicUser->getLogin()}       				
						{/if}
				</option>
			{/if}
		{/if}
		<option value="{$oUserCurrent->getId()}">
       			{if $oUserCurrent->getProfileName() ne ""}
       				{$oUserCurrent->getProfileName()}
				{else}
	       			{$oUserCurrent->getLogin()}       				
				{/if}
		</option>
		{foreach from=$aUserList item=item}
		<option value="{$item.user_id}">{$item.user_profile_name}{$item.user_login}</option>
		{/foreach}	
	</select>
	<span class="note">{$aLang.plugin.publishfrom.publishfrom_note}</span>
</p>
