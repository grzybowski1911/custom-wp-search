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
    </div>
</div>


<?php get_footer(); ?>