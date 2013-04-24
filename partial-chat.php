<div id="gigya-chat-container"></div>
<script>
var params = {categoryID:<?php echo $this->chat_ID; ?>,width:<?php echo isset( $this->params['width'] ) ? $this->params['width'] : 300;?>,height:450,containerID:'gigya-chat-container',cid:''};
gigya.services.socialize.showChatUI(conf,params);
</script>
