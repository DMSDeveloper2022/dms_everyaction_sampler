<?php

// Support custom "anchor" values.
$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wba-ftm-wrapper';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

$f_post_obj = get_field('featured_team_member');

$pst = $f_post_obj['featured_post'];

$layout = !empty(get_field('content_preference')) ? get_field('content_preference') : 'excerpt';

$class_name .= ' layout-' . $layout;

$color_scheme = !empty(get_field('color_scheme')) ? get_field('color_scheme') : 'light';

$class_name .= ' wba-ftm-color-scheme-' . $color_scheme;

$show_quote = !empty(get_field('show_quote')) ? get_field('show_quote') : false;

$hide_read_more = !empty(get_field('hide_read_more')) ? get_field('hide_read_more') : false;

$excerpt_length = !empty(get_field('excerpt_word_length')) ? get_field('excerpt_word_length') : 150;

$quote = $show_quote && !empty(get_field('member_quote', $pst->ID)) ? '"' . get_field('member_quote', $pst->ID) . '"' : '';

$alt_image = !empty(get_field('alternative_profile_image')) ? get_field('alternative_profile_image') : false;

if (!empty($alt_image)) {
    $img = wp_get_attachment_image_url($alt_image, 'large');
} else {

    $img = get_the_post_thumbnail_url($pst->ID, 'large');
}
$reveal_css = $layout === 'reveal' ? 'closed' : '';


$reveal_height = $layout === 'reveal' && !empty(get_field('initial_height')) ?  get_field('initial_height') . 'px' : '200px';

$reveal_style =
    $layout === 'reveal' ?  "max-height: " . $reveal_height : 'max-height: 9999px';


$title = get_field('title', $pst->ID);

$icon_img = '';

$icon_name = $layout === 'reveal' ?  "wba-logo-sm-ltgray.svg" : 'wba-logo-sm-turquoise.svg';


$icon_img = '<img class="wba-fcs-publication-icon" src="' . get_stylesheet_directory_uri() . '/images/' . $icon_name . '"   />';

?>
<div class="<?php echo $class_name ?>" <?php echo $anchor ?>>

    <?php if ($layout !== 'board') { ?>
        <div class="wba-ftm-image">
            <div class="wba-ftm-image-inner " style="background:url(<?php echo $img ?>) center no-repeat"></div>
        </div>
    <?php } ?>
    <div class="wba-ftm-content">
        <div class="wba-ftm-title-wrap">
            <div class="wba-ftm-title">
                <h3><?php echo esc_html($pst->post_title); ?><?php if ($layout === 'board') {
                                                                    echo ',';
                                                                } ?></h3>
                <h4><?php echo esc_html($title) ?></h4>

            </div>

            <?php if ($layout !== 'board') { ?>
                <div class="wba-ftm-icon">
                    <?php echo $icon_img ?>

                </div>
            <?php } ?>
        </div>
        <hr class="wba-ftm-hard-rule" />
        <?php if ($layout === 'reveal') { ?>
            <div class="wba-ftm-bio <?php echo $reveal_css ?>" data-height="<?php echo $reveal_height ?>" style="<?php echo $reveal_style ?>;overflow: hidden">
            <?php } ?>
            <?php if ($show_quote) {
            ?>
                <div class="wba-ftm-quote">
                    <?php echo $quote ?>
                </div>
            <?php } ?>
            <div class=" wba-ftm-excerpt">

                <?php if ($layout === 'excerpt') {
                    echo DMS_Utilities::content($pst->post_content, $excerpt_length);
                } elseif ($layout === 'board') {

                    echo get_the_excerpt($pst->ID);
                } else {
                    echo apply_filters('the_content', $pst->post_content);
                }
                ?>

            </div>
            <?php if ($layout === 'excerpt') { ?>
                <div class="wba-ftm-read-more">


                    <a href="<?php echo get_permalink($pst->ID) ?>">Read More</a>

                </div>
            <?php } ?>
            <?php if ($layout === 'reveal') { ?>
            </div>
        <? } ?>

        <?php if ($layout === 'reveal' && !$hide_read_more) { ?>
            <div class="wba-ftm-read-more">

                <div class="read-more-reveal wba-arrow wba-arrow-after wba-arrow-down wba-arrow-20 ">Read More</div>


            </div>
        <?php } ?>


    </div>
    <?php if ($layout === 'board') { ?>
        <div class="wba-ftm-read-more">


            <a href="<?php echo get_permalink($pst->ID) ?>">Read More</a>

        </div>
    <?php } ?>

</div>
<?php if ($layout === 'excerpt') { ?>
    <div class="wba-ftm-stars three-stars-white" style="grid-column: span 2;margin-top: 50px ">
    </div>
<?php } ?>
</div>