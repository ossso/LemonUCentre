<?php include '../gfw.php'; ?>
{if $pagebar && $pagebar.PageAll > 1}
<div class="pagebar" data-pagebar>
    {foreach $pagebar.buttons as $key => $v}
        {if $key == $pagebar.PageNow}
        <span class="page-item page-now page-btn">{$key}</span>
        {else}
        <span class="page-item page-btn"><a data-async-link href="{$v}">{$key}</a></span>
        {/if}
    {/foreach}
</div>
{/if}
