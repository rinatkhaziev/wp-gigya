<div id="commentsDiv"></div>
<script type='text/javascript'>
var params ={
	categoryID: '<?php echo $this->comments_ID; ?>',
	streamID: '<?php echo esc_url( get_permalink() );?>',
	containerID: 'commentsDiv',
	cid:'',
	scope: 'both',
	privacy: 'public',
	width: '100%'
}

gigya.services.socialize.showCommentsUI(conf,params);

</script>
