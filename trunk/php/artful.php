<!DOCTYPE html>
<html>
    <?php require_once('../../../../wp-load.php'); ?>
    <?php $include_url = includes_url(); ?>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="<?php echo $include_url; ?>/js/tinymce/tiny_mce_popup.js" type="text/javascript"></script>
    </head>
    <body>
        <div style="margin-top : 90px; margin-left : 174px;">
            <p>Please Select a Widget : </p>
            <select name="event-name" id="event-name">
                <option value="">Choose an Option</option>
                <option value="event">Event</option>
                <option value="donation">Donation</option></select>
            <div id="get-event"></div>
        </div>
    </body>
</html>

<script type="text/javascript">
    function bindShortcodeButton() {
        jQuery('.get-content').on('click',function(){

            if(jQuery(this).hasClass('event')){
                var value = jQuery('#get-event-id').val();
                var shortcode = '[art-event id="'+value+'"]';
                tinymce.activeEditor.execCommand("mceInsertContent",0,shortcode);
            }
            if(jQuery(this).hasClass('donation')){
                var value = jQuery('#get-event-id').val();
                var shortcode = '[art-donation id="'+value+'"]';
                tinymce.activeEditor.execCommand("mceInsertContent",0,shortcode);
            }
            window.top.tb_remove();
        });
    }

    jQuery(document).ready(function(){
        jQuery('#event-name').on('change',function(){
            var value = jQuery(this).val();
            if(value == ''){
                jQuery('#get-event').html('');
            }
            if(value == 'event'){
                jQuery('#get-event').html(
                '<p> Please Enter An Event ID In Text Box Provided Below </p><br/>'+
                    '<p>Enter Event ID : <input type="text" id="get-event-id" size="10"/></p>'+
                    '<p><input type="button" value="Create Shortcode" id="TB_closeWindowButton" class="button event get-content" style="background: none repeat scroll 0 0 #E5E5E5 !important; border: 1px solid #FFFFFF; box-shadow: 0 0 2px 0 #666666; cursor: pointer; padding: 2px 5px;"/></p>'
            );
            bindShortcodeButton();
            }else if(value=='donation'){
                jQuery('#get-event').html(
                '<p> Please Enter The Organization API Key In Text Box Provided Below </p><br/>'+
                    '<p>Enter Organization ID : <input type="text" id="get-event-id" size="10"/></p>'+
                    '<p><input type="button" value="Create Shortcode" id="TB_closeWindowButton" class="button donation get-content" style="background: none repeat scroll 0 0 #E5E5E5 !important; border: 1px solid #FFFFFF; box-shadow: 0 0 2px 0 #666666; cursor: pointer; padding: 2px 5px;"/></p>'
            );
            bindShortcodeButton();
            }
        });

    });
</script>
  