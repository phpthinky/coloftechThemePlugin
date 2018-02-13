{**
 * templates/frontend/components/navigationMenu.tpl
 *
 * Copyright (c) 2018 Vitaliy Bezsheiko, MD
 * Distributed under the GNU GPL v3.
 *
 *}

{if $navigationMenu}
    {if $id|escape == "navigationPrimary"}
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{url page="index"}"><i class="fa fa-home"></i></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">


        {foreach key=field item=navigationMenuItemAssignment from=$navigationMenu->menuTree}
      {if !$navigationMenuItemAssignment->navigationMenuItem->getIsDisplayed()}
        {php}continue;{/php}
      {/if}
        {if !empty($navigationMenuItemAssignment->children)}
          <li class="{$liClass|escape} dropdown">
            <a class="dropdown-toggle" href="{$navigationMenuItemAssignment->navigationMenuItem->getUrl()}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {$navigationMenuItemAssignment->navigationMenuItem->getLocalizedTitle()}
                        <span class="caret"></span></a> 
          <ul class="dropdown-menu">
            {foreach key=childField item=childNavigationMenuItemAssignment from=$navigationMenuItemAssignment->children}
              {if $childNavigationMenuItemAssignment->navigationMenuItem->getIsDisplayed()}
                <li class="{$liClass|escape}">
                  <a href="{$childNavigationMenuItemAssignment->navigationMenuItem->getUrl()}">
                    {$childNavigationMenuItemAssignment->navigationMenuItem->getLocalizedTitle()}
                  </a>
                </li>
              {/if}
            {/foreach}
          </ul>

                    </li>

                {else}
                    <li class="{$liClass|escape}">
                        <a class="" href="{$navigationMenuItemAssignment->navigationMenuItem->getUrl()}">{$navigationMenuItemAssignment->navigationMenuItem->getLocalizedTitle()}</a>
                    </li>
                {/if}
    {/foreach}
      </ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

    {else}
<ul id="{$id|escape}" class="{$ulClass|escape} ">
            {foreach key=field item=navigationMenuItemAssignment from=$navigationMenu->menuTree}
                {if !$navigationMenuItemAssignment->navigationMenuItem->getIsDisplayed()}
                    {php}continue;{/php}
                {/if}
                {if !empty($navigationMenuItemAssignment->children)}
                    <li class="{$liClass|escape} dropdown">
                        <a class=" dropdown-toggle" href="{$navigationMenuItemAssignment->navigationMenuItem->getUrl()}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {$navigationMenuItemAssignment->navigationMenuItem->getLocalizedTitle()}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            {foreach key=childField item=childNavigationMenuItemAssignment from=$navigationMenuItemAssignment->children}
                                {if $childNavigationMenuItemAssignment->navigationMenuItem->getIsDisplayed()}
                                <li>
                                  
                                    <a class="{$liClass|escape} dropdown-item" href="{$childNavigationMenuItemAssignment->navigationMenuItem->getUrl()}">
                                        {$childNavigationMenuItemAssignment->navigationMenuItem->getLocalizedTitle()}
                                    </a>
                                </li>
                                {/if}
                            {/foreach}
                        </ul>
                    </li>
                {else}
                    <li class="{$liClass|escape} navbar-right">
                        <a class="" href="{$navigationMenuItemAssignment->navigationMenuItem->getUrl()}">{$navigationMenuItemAssignment->navigationMenuItem->getLocalizedTitle()}</a>
                    </li>
                {/if}
            {/foreach}
        </ul>
    {/if}
{/if}