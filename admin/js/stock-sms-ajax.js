jQuery(document).ready(function(){
    //stock entry point tips
    jQuery('#entry_form #submit_entry').on('click',function(event){
        event.preventDefault();
        var stock_name = jQuery('#stock_name').val();
        var stock_qty = jQuery('#stock_qty').val();
        var entry_point = jQuery('#entry_point').val();
        var entry_time = jQuery('#entry_time').val();
        console.log('clicked');
        jQuery.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action:'add_entry_tip',
                'stock_name':stock_name,
                'stock_qty':stock_qty,
                'entry_point':entry_point,
                'entry_time':entry_time
            },
            success:function(data){
                jQuery('#entry_form').after('<pre>'+data+'</pre>');
                jQuery('#entry_form').after(data);
            },
            error:function(data){
                jQuery('#entry_form').after('<pre>'+data+'</pre>');
                jQuery('#entry_form').after(data);
            }
        })
    });
    //stock exit point tips
    jQuery('#exit_form #submit_exit').on('click',function(event){
        event.preventDefault();
        var tip_id = jQuery('#tip_id').val();
        var exit_point = jQuery('#exit_point').val();
        var exit_time = jQuery('#exit_time').val();
        console.log('clicked');
        jQuery.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action:'add_exit_tip',
                'tip_id':tip_id,
                'exit_point':exit_point,
                'exit_time':exit_time
            },
            success:function(data){
                jQuery('#exit_form').after('<pre>'+data+'</pre>');
                jQuery('#exit_form').after(data);
            },
            error:function(data){
                jQuery('#exit_form').after('<pre>'+data+'</pre>');
                jQuery('#exit_form').after(data);
            }
        })
    });
});