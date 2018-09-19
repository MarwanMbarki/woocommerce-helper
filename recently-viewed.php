	<section id="recently-viewed" class="related products">
		<h5>Recently viewed </h5>
		<ul class="products columns-4">
			<?php
			extract(shortcode_atts(array(
				"per_page" => '5'
			), $atts));
			// Get WooCommerce Global
			global $woocommerce;
			// Get recently viewed product cookies data
			$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
			$viewed_products = array_filter( array_map( 'absint', $viewed_products ) );
			// If no data, quit
			if ( empty( $viewed_products ) )
			return __( 'You have not viewed any product yet!', 'rc_wc_rvp' );
			// Create the object
			ob_start();
			// Get products per page
			if( !isset( $per_page ) ? $number = 5 : $number = $per_page )
			// Create query arguments array
			$query_args = array(
				'posts_per_page' => $number,
				'no_found_rows'  => 1,
				'post_status'    => 'publish',
				'post_type'      => 'product',
				'post__in'       => $viewed_products,
				'orderby'        => 'rand'
			);

			// Add meta_query to query args
			$query_args['meta_query'] = array();
			// Check products stock status
			$query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
			// Create a new query
			$loop = new WP_Query($query_args);
			// ----
			if (empty($loop)) {
				return __( 'You have not viewed any product yet!', 'rc_wc_rvp' );
			}?>
			<?php while ( $loop->have_posts() ) : $loop->the_post();
			global $product;
			$url= wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

			?>
			<li class="product">
				<a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="65px" height="115px" />'; ?>
					<h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
					<span class="price"><?php echo $product->get_price_html(); ?></span>
				</a>
				<?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
			</li><!-- /span3 -->
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
	</ul><!-- /row-fluid -->
	</section><!-- /recent -->