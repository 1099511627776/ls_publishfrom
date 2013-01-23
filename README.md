[![Build Status](https://travis-ci.org/1099511627776/ls_publishfrom.png?branch=master)](https://travis-ci.org/1099511627776/ls_publishfrom)

ls_publishfrom
==============

DESCRIPTION\ОПИСАНИЕ
---------------------

LiveStreet plugin that allow administrators to change author of topic
Original plugin was written by Doka (http://livestreet.ru/profile/Doka/) for 0.5.1 version
This version is adaptation for LS 1.0.1 and also adds API for publishing original author of topic
and last user that edited topic.

Плагин для LiveStreet который позволяет администраторам изменять авторов топиков.
Оригинальный плагин написан Doka (http://livestreet.ru/profile/Doka/) под версию 0.5.1
Эта версия - адаптация под LS 1.0.1 которая также содержит дополнительные функции которые позволяют
отображать оригинального пользователя создавшего топик, а также последнего, кто редактировал топик.


API EXAMPLE
------------

The easiest way to use this API is to modify topic_part_header.tpl of any LS Template and add this:
Самый простой путь использование этого API - модифицировать файл topic_part_header.tpl любого Шаблона LS добавив следующее:

            {if $oUserCurrent and ($oUserCurrent->isAdministrator())}
            	{if $oTopic->getAddedUserId()}
	            	<li>Created: {$oTopic->getAddedUser()->getLogin()}</li>
            	{/if}
            	{if $oTopic->getLastEditUserId()}
            		<li>Last Edit: {$oTopic->getLastEditUser()->getLogin()}</li>
				{/if}
            {/if}	
