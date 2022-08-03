<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

$categories_list = wp_list_categories( array(
    'current_category' => get_the_ID(),
    'echo' => 0,
    'title_li' => '',
    'style' => '',
    'separator' => ', ',
) );

$time_string = '<time itemprop="datePublished" class="entry-date published updated" datetime="%1$s">%2$s</time>';
$time_string = sprintf( 
    $time_string,
    esc_attr( get_the_date( DATE_W3C ) ),
    esc_html( get_the_date() )
);

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>" itemscope itemtype="https://schema.org/CreativeWork">

    <?php if (has_post_thumbnail()) : ?>

    <div class="entry-featured-image">
        <a href="<?php echo get_permalink() ?>" class="entry-featured-image-link">
            <?php echo get_the_post_thumbnail($post->ID, 'medium_large'); ?>
        </a>
    </div>

    <?php endif; ?>

    <div class="entry-content">

        <div class="post-meta">

            <?php if ($categories_list) : ?>

            <span class="post-category">
                <?php printf( '<span class="cat-links">' . esc_html__( '%s', 'divi' ) . '</span>', $categories_list ); // WPCS: XSS OK. ?>
            </span>

            <?php endif; ?>

            <span class="post-published">
                <?php echo $time_string; ?>
            </span>

        </div>

        <?php
            the_title(
                sprintf('<h3 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
                '</a></h3>'
            );
        ?>

        <!-- <div class="entry__readmore">
            <a href="<?php echo get_permalink() ?>">
                <span>></span>
            </a>
        </div> -->


    </div>
</article>