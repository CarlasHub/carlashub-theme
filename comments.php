<?php
/**
 * Comments template.
 *
 * @package CarlasHub_V2
 */

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="comments-area">
	<div class="panel section-panel">
		<p class="eyebrow"><?php esc_html_e( 'Discussion', 'carlashub-v2' ); ?></p>
		<h2>
			<?php
			printf(
				esc_html(
					_n( '%d comment', '%d comments', get_comments_number(), 'carlashub-v2' )
				),
				(int) get_comments_number()
			);
			?>
		</h2>
		<p class="section-intro"><?php esc_html_e( 'Comments are treated like a thread attached to the document rather than an afterthought below it.', 'carlashub-v2' ); ?></p>
	</div>

	<?php if ( have_comments() ) : ?>
		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php the_comments_pagination(); ?>

		<?php if ( ! comments_open() ) : ?>
			<div class="panel section-panel">
				<p><?php esc_html_e( 'Comments are closed.', 'carlashub-v2' ); ?></p>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div class="panel section-panel">
		<?php
		comment_form(
			array(
				'title_reply'        => __( 'Join the thread', 'carlashub-v2' ),
				'title_reply_before' => '<h2 class="widget-title">',
				'title_reply_after'  => '</h2>',
			)
		);
		?>
	</div>
</section>
