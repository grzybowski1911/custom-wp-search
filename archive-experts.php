<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php 
            while ( have_posts() ) { the_post();
                the_title( '<h2>', '</h2>' );
                ?>
                <p><?php 
                    $terms = get_the_terms( $post->ID, 'experts_industries' );
                    if($terms) {
                        $terms_string = join(', ', wp_list_pluck($terms, 'name'));
                        echo $terms_string; 
                    } else {
                        echo 'no taxonomy';
                    }
                    ?></p>
                    <p><?php 
                    $terms = get_the_terms( $post->ID, 'experts_specialities' );
                    if($terms) {
                        $terms_string = join(', ', wp_list_pluck($terms, 'name'));
                        echo $terms_string; 
                    } else {
                        echo 'no taxonomy';
                    }
                    ?></p>
                    <p><?php 
                    $terms = get_the_terms( $post->ID, 'experts_locations' );
                    if($terms) {
                        $terms_string = join(', ', wp_list_pluck($terms, 'name'));
                        echo $terms_string; 
                    } else {
                        echo 'no taxonomy';
                    }
                    ?></p>
            <?php
            }
            ?>
        </div>
        <!-- adding ajax boiler plate code 
            <div id="no-more">No More Designs!</div>
            <div id="loaderDiv"><img id="loaderImg" src="/wp-content/uploads/2022/07/signal-tattoo-transparent.png" alt=""></div>
            <span id="load-more">View More</span>
        -->
        <div class="col-12">
            <?php understrap_pagination(); ?>
        </div>
    </div>
</div>


<?php get_footer(); ?>