<div id="highlight-products_block_center" class="block products_block clearfix">
    {if isset($product_highlight) AND $product_highlight}
        {var_dump($product_highlight)}
        <div class="block_content">
            <a href="{$product_highlight['link']|escape:'html'}" title="{$product_highlight['name']|escape:html:'UTF-8'}" class="featured-highlight">
                <div class="highlight-image">
                    <img src="{$product_highlight['image']|escape:'html'}" height="{$homeSize.height}" width="{$homeSize.width}" alt="{$product_highlight['name']|escape:html:'UTF-8'}" />
                    <span class="recommanded">{l s="Recommanded product" mod="highlightitem"}</span>
                </div>
                <div class="highlight-description">
                    <h5 class="s_title_block">{$product_highlight['name']|truncate:35:'...'|escape:'html':'UTF-8'}</h5>
                    <div class="products_desc">{$product_highlight['description']|truncate:300:'...'}</div>
                    <button href="{$product_highlight['link']|escape:'html'}" title="{$product_highlight['name']|escape:html:'UTF-8'}">{l s="Buy at" mod="highlightitem"} {$product_highlight['price']}{$product_highlight['currency']}</button>
                </div>
            </a>
        </div>
    {else}
        <p>{l s='No highlight products' mod='highlightitem'}</p>
    {/if}
</div>
<!-- /MODULE Home Featured Products -->
