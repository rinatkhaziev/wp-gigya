<script type="text/javascript">

var myReactions=[
<?php
$reactions = array();
$tdir = get_stylesheet_directory_uri();
foreach ( $this->params as $key => $slug ) {
	$reactions[] = "{
		text: '',
		ID: '{$slug}',
		iconImgUp: '{$tdir}/img/reaction-bar/{$slug}.png',
		iconImgOver: '{$tdir}/img/reaction-bar/{$slug}_active.png',
		iconImgDown: '{$tdir}/img/reaction-bar/{$slug}_active.png',
		tooltip: '{$key}',
		feedMessage: '{$key}',
		headerText: '{$key}',
	}";
}
	echo implode( ",\n", $reactions );
?>
	]

var showReactionsBarUI_params=
{
	barID: '<?php echo esc_js( get_permalink() ) ?>',
	showCounts: 'top',
	containerID: 'reactionsDiv',
	reactions: myReactions,
	userAction: act,
	showSuccessMessage: false,
	noButtonBorders: true,
	promptShare: false,
	multipleReactions: false,
	onReactionClicked: function( eventObj ) {
		jQuery('#commentsDiv textarea').focus();
	},
	onLoad: function( eventObj ) {
		jQuery('.gig-reaction-button').tooltip({ show: false, hide: false });
	}
}
</script>

<div id="reactionsDiv"></div>
<script type="text/javascript">
   gigya.services.socialize.showReactionsBarUI(showReactionsBarUI_params);
</script>
