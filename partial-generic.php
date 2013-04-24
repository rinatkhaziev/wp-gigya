<?php
global $post;
$rand = mt_rand( 1, 100000000 ); //for containerID
remove_filter( 'the_excerpt', 'wpautop' );
// Default ID to the ID of post that in global $post
$post_id = $post->ID;

// We have a post object passed
if ( isset( $this->params['data']->ID ) )
	$post_id = (int) $this->params['data']->ID;

?>
	<script type="text/javascript">

var act = new gigya.services.socialize.UserAction();
act.setActionName("recommended");
act.setTitle("<?php echo $this->validate_and_format_string_for_js( !empty( $this->params['title'] ) ? $this->params['title'] : get_the_title( $post_id ) );?>");
act.setLinkBack("<?php echo esc_url( get_permalink( $post_id )  );?>");
act.setDescription("<?php echo $this->validate_and_format_string_for_js( strip_tags( !empty( $this->params['description'] ) ? $this->params['description'] : get_the_excerpt( ) ) ); ?>");
act.addActionLink("Read the story", "<?php echo esc_url( !empty( $this->params['url'] ) ? $this->params['url'] : get_permalink( $post_id ) );?>");
<?php
if ( has_post_thumbnail() ):
	$general_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'general-thumbnail' );
?>
act.addMediaItem({ type: 'image', src: '<?php echo esc_attr( $general_thumbnail[0] )?>', href: '<?php echo esc_url( get_permalink( $post_id ) );?>' });
<?php endif; ?>

var showShareBarUI_params=
{
	containerID: 'componentDiv<?php echo $rand;?>',
	<?php if ( empty( $this->params ) ): ?>
	shareButtons:
	[
		{
			provider: 'facebook-like',
			action: 'recommend',
			url: '<?php the_permalink() ;?>'
		},
		{
			provider: 'facebook',
			iconOnly: true,
			url: '<?php the_permalink() ;?>'
		},
		{
			provider: 'pinterest'
		},
		{
			provider: 'share'
		},
		{
			provider: 'twitter',
			iconOnly: false
		},
		{
			provider: 'email'
		}
	],

	<?php elseif ( is_array( $this->params ) && array_key_exists( 'gigya_services', $this->params ) ): ?>
	shareButtons:
	[
<?php

	$services_cnt = count( $this->params['gigya_services'] );
$provider_iterator = 0;

foreach ( $this->params['gigya_services'] as $provider ) {
	++$provider_iterator;
	echo '{';
	$cnt = count( $provider );
	$provider_items_iterator = 0;
	foreach ( $provider as $k => $v ) {
		++$provider_items_iterator;
		echo esc_js( $k ) .':' . "'" . esc_js( $v ) . "'";
		if ( $provider_items_iterator < $cnt )
			echo ',';
	}
	echo '}';
	if ( $provider_iterator < $services_cnt )
		echo ',';
} ?>
	]
	,<?php endif; ?>
	iconsOnly: 'true',
	scope: 'both',
	operationMode: 'autoDetect',
	privacy: 'public',
	userAction: act
}
</script>
<div id="componentDiv<?php echo $rand;?>"></div>
<script type="text/javascript">
   gigya.services.socialize.showShareBarUI(conf,showShareBarUI_params);
</script>
<?php add_filter( 'the_excerpt', 'wpautop' ); ?>
