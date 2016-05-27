<!-- Block mymodule -->
<div id="pcbuilder_block_home" class="block">
  <h1>Welcome!</h1>
  <div class="block_content">
    <p>Hello,
       {if isset($pcbuilder) && $pcbuilder}
           {$pcbuilder}
       {else}
           World
       {/if}
       !
    </p>
    <ul>
      <li><a href="{$pcbuilder_link}" title="Click this link">Assembler mon pc!</a></li>
    </ul>
  </div>
</div>
<!-- /Block mymodule -->