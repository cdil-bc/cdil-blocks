<?php
/**
 * Title:       Sidebar
 * Slug:        cdilblocks/sidebar
 */
?>


<!-- wp:group {"className":"sidebar","layout":{"type":"constrained"}} -->
<div class="wp-block-group sidebar">

	
<?php 

$current_page = get_page_by_path($_SERVER['REQUEST_URI']);
            
if(isset($current_page->ID)) {
    $current_page_id = $current_page->ID;
}
// echo $current_page_id;

$post = get_post($current_page_id);

$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $post->ID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 ); 

$parent = new WP_Query( $args );

?>
<nav class="section-contents">
<ul class="parent-page">

<?php if ( $parent->have_posts() ) : ?>
    <?php while ( $parent->have_posts() ) : $parent->the_post(); 
    $child_id = get_the_ID();
    $children = get_pages('child_of='.$child_id);
    $count = count($children);?>    
    <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
      <?php if( count( $children ) != 0 ): ?>
        <span class="child-count"> <?php echo $count ?></span>
       <?php endif; ?>
      <?php if ( ! has_excerpt() ) :
      echo '';  
      else: ?>
        <p class="entry-subtitle"><?php echo get_the_excerpt(); ?></p>
      <?php endif; ?></li>
    <?php endwhile; ?>

<?php endif; wp_reset_postdata(); ?>

</nav>
</ul>
<?php
function new_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'new_excerpt_more');

?>


</div>
<!-- /wp:group -->