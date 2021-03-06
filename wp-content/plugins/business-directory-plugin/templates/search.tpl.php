<?php
$api = wpbdp_formfields_api();
?>
<div id="wpbdp-search-page" class="wpbdp-search-page businessdirectory-search businessdirectory wpbdp-page">
    <div class="wpbdp-bar cf"><?php wpbdp_the_main_links(); ?></div>
    <h2 class="title"><?php _ex('Search', 'search', 'WPBDM'); ?></h2>

    <?php if ( 'above' == $search_form_position ): ?>
    <?php echo $search_form; ?>
    <?php endif; ?>

    <!-- Results -->
    <?php if ($searching): ?>    
        <h3><?php _ex('Search Results', 'search', 'WPBDM'); ?></h3>    

        <?php do_action( 'wpbdp_before_search_results' ); ?>
        <div class="search-results">
        <?php if (have_posts()): ?>
            <?php echo wpbdp_render('businessdirectory-listings'); ?>
        <?php else: ?>
            <?php _ex("No listings found.", 'templates', "WPBDM"); ?>
            <br />
            <?php echo sprintf('<a href="%s">%s</a>.', wpbdp_get_page_link('main'),
                               _x('Return to directory', 'templates', 'WPBDM')); ?>    
        <?php endif; ?>
        </div>
        <?php do_action( 'wpbdp_after_search_results' ); ?>
    <?php endif; ?>

    <?php if ( 'below' == $search_form_position ): ?>
    <?php echo $search_form; ?>
    <?php endif; ?>

</div>
