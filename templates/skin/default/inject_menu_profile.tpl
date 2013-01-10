{if $oUserCurrent && $oUserProfile && $oUserCurrent->getId()==$oUserProfile->getId()}
<li {if $aParams[0]=='excludedtopics'}class="active"{/if}>
    <a href="{router page='profile'}{$oUserProfile->getLogin()}/excludedtopics/">{$aLang.plugin.topicup.menu_profile_excludedtopics}{if $iExcludedTopics} (<span id="excludedTopicsCount">{$iExcludedTopics}</span>){/if}</a>
</li>
{/if}