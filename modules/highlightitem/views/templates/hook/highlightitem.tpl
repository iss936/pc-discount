<div id="highlight-products_block_center" class="block products_block clearfix">
    {if isset($product_highlight) AND $product_highlight}
        <div class="block_content">
            <a href="{$product_highlight['link']|escape:'html'}" title="{$product_highlight['name']|escape:html:'UTF-8'}" class="featured-highlight">
                <div class="highlight-image">
                    <img src="{$product_highlight['image']|escape:'html'}" height="{$homeSize.height}" width="{$homeSize.width}" alt="{$product_highlight['name']|escape:html:'UTF-8'}" />
                    <span class="recommanded">{l s='Recommanded product' mod='highlightitem'}</span>
                </div>
                <div class="highlight-description">
                    <div class="star_content clearfix">
                        {section name="i" start=0 loop=5 step=1}
                            {if $smarty.section.i.index lt $product_highlight['grade']}
                                <div class="star star_on"></div>
                            {else}
                                <div class="star"></div>
                            {/if}
                        {/section}
                    </div>
                    <h5 class="s_title_block">{$product_highlight['name']|truncate:35:'...'|escape:'html':'UTF-8'}</h5>
                    <div class="products_desc">{$product_highlight['description']|truncate:800:'...'}</div>
                </div>
                <button class="button-highlight" href="{$product_highlight['link']|escape:'html'}" title="{$product_highlight['name']|escape:html:'UTF-8'}">{l s='Buy at' mod='highlightitem'} <span class="price">{$product_highlight['price']}{$product_highlight['currency']}</span></button>
            </a>
        </div>
    {else}
        <p>{l s='No highlight products' mod='highlightitem'}</p>
    {/if}
</div>
