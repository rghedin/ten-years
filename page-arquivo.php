<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! twentynineteen_can_show_post_thumbnail() ) : ?>
	<header class="entry-header">
		<?php get_template_part( 'template-parts/header/entry', 'header' ); ?>
	</header>
	<?php endif; ?>

	<div class="entry-content">
		<p>No ar desde 15 de outubro de 2013, o <strong>Manual do Usuário</strong> já publicou <?php $agentwp_num = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND post_name NOT LIKE '%revision%' AND post_name NOT LIKE '%autosave%'" );

				if (0 < $agentwp_num) $agentwp_num = number_format($agentwp_num);
				echo $agentwp_num.' posts'; ?>. Por esta página, você pode navegar de diferentes formas no rico arquivo do site — por seções, data ou assunto. Caso precise de algo específico, use a pesquisa no final da página.</p>

				<div style="max-width: 40%; float: left; margin-bottom: 2em"><h2>Seções</h2>
				<ul>
					<?php
					wp_list_categories( array(
						'orderby'    => 'count',
						'order'      => 'DESC',
						'show_count' => 1,
						'title_li'   => '',
						'number'     => 0,
					) );
					?>
				</ul>

				<h2>Assuntos populares</h2>
				<?php wp_tag_cloud( array(
					'smallest' => 12,
					'largest'  => 32,
					'unit'     => 'px',
					'number'   => 0,
					'orderby'  => 'name',
					'order'    => 'ASC',
					'taxonomy' => 'post_tag'
				) ); ?></div>

				<div style="text-transform: capitalize; width: 50%; float: right; margin-bottom: 2em"><h2>Podcasts</h2>
					<ul>
						<li><a href="https://manualdousuario.net/series/guia-pratico/">Guia Prático</a></li>
						<li><a href="https://manualdousuario.net/series/tecnocracia/">Tecnocracia</a></li>
					</ul>

				<h2>Mensal</h2>
				<ul>
					<?php $args = array(
						'type'            => 'monthly',
						'limit'           => '',
						'format'          => 'html',
						'before'          => '',
						'after'           => '',
						'show_post_count' => 1,
						'echo'            => 1,
						'order'           => 'DESC',
						'post_type'     => 'post'
					);
					wp_get_archives( $args ); ?>
				</ul></div>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Post title. Only visible to screen readers. */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'twentynineteen' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">' . twentynineteen_get_icon_svg( 'edit', 16 ),
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
