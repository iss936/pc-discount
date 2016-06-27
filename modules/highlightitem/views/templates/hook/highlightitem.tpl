<div id="highlight-products_block_center" class="block products_block clearfix">
    {if isset($product_highlight) AND $product_highlight}
        {var_dump($product_highlight)}
        <div class="block_content">
            <ul style="height:250px;">
                    <li class="ajax_block_product item">
                        <a href="{$product_highlight['link']|escape:'html'}" title="{$product_highlight['name']|escape:html:'UTF-8'}" class="products_image"><img src="{$product_highlight['image']|escape:'html'}" height="{$homeSize.height}" width="{$homeSize.width}" alt="{$product_highlight['name']|escape:html:'UTF-8'}" /></a>
                        <h5 class="s_title_block"><a href="{$product_highlight['link']|escape:'html'}" title="{$product_highlight['name']|truncate:50:'...'|escape:'html':'UTF-8'}">{$product_highlight['name']|truncate:35:'...'|escape:'html':'UTF-8'}</a></h5>
                        <div class="products_desc"><a href="{$product_highlight['link']|escape:'html'}" title="{l s='More' mod='highlightitem'}">{$product_highlight['description']|truncate:65:'...'}</a></div>
                        <div>
                            <a class="lnk_more" href="{$product_highlight['link']|escape:'html'}" title="{l s='View' mod='highlightitem'}">{l s='View' mod='highlightitem'}</a>
                            <script>console.log('tata');</script>
                            {if $products_highlight['available_for_order'] AND !isset($restricted_country_mode) AND $products_highlight['minimal_quantity'] == 1 AND $products_highlight['customizable'] != 2 AND !$PS_CATALOG_MODE}
                                {if ($products_highlight['quantity'] > 0)}
                                    <a class="exclusive ajax_add_to_cart_button" rel="ajax_id_products_{$products_highlight['id']}" href="{$link->getPageLink('cart')|escape:'html'}?qty=1&amp;id_product={$products_highlight['id']}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='highlightitem'}">{l s='Add to cart' mod='highlightitem'}</a>

                                <script>console.log('tutu');</script>
                                {else}
                                    <span class="exclusive">{l s='Add to cart' mod='highlightitem'}</span>

                                <script>console.log('titi');</script>
                                {/if}
                            {else}
                                <div style="height:23px;"></div>
                                <script>console.log('tete');</script>
                            {/if}
                        </div>
                    </li>
            </ul>
        </div>
    {else}
        <p>{l s='No highlight products' mod='highlightitem'}</p>
    {/if}
</div>
<!-- /MODULE Home Featured Products -->
