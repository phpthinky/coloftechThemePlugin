{php}
//$slider = coloftechThemePlugin::getActivejournal();
//$useinfo = coloftechThemePlugin::getEditors(1);


{/php}

{if $journalId eq 1}  {*get the ID of active journal*}
    
    {include file="frontend/pages/journalEditors.tpl"}


    {include file="frontend/pages/journalManagementTeam.tpl"}


    {include file="frontend/pages/journalAuthors.tpl"}

{/if} {*end of get the ID of active journal*}