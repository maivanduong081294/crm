<?php get_header(); ?>
<section id="search">
    <?php
    $key = isset($_GET['s'])?$_GET['s']:'';
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => '-1',
        'post_status' => 'publish',
    );
    if(isset($_GET['s'])){
        $args['s'] = $_GET['s'];
        $args['sentence'] = true;
    }
    $the_query =  new WP_Query($args);
    ?>
    <div class="groupPost search-results">
        <div class="container">
            <div class="row sectionSearchResul">
                <div class="searchResultsCount col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <p><?php echo count($the_query->posts); ?> search results</p>
                </div>
                <div class="titleSearch col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h1><?php echo $key; ?></h1>
                </div>
            </div>

            <?php if($the_query->have_posts()): ?>
                <?php
                    $args['post_type'] = 'post';
                    $the_query =  new WP_Query($args);
                ?>
                <?php if($the_query->have_posts()): ?>
                    <div class="homepage">
                        <div class="imgPosts">
                            <div class="row">
                                <?php while($the_query->have_posts()): $the_query->the_post(); ?>
                                    <div class="col-sm-3 col-xs-6 colImages">
                                        <?php get_template_part('content', get_post_format()); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
