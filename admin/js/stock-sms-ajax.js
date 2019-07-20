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
                console.log('success');
                console.log(data.code);
                if(data.code === '200'){
                    jQuery('#entry_form').after( get_noticebar_html(data.status,data.message) );
                }
                else if(data.code === '400'){
                    jQuery('#entry_form').after( get_noticebar_html(data.status,data.message) );
                }else if(data.code === '500'){
                    jQuery('#entry_form').after( get_noticebar_html(data.status,data.message) );
                }
            },
            error:function(data){
                console.log('failed');
                jQuery('#exit_form').after( get_noticebar_html(data.status,data.message) );
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
                console.log('success');
                if(data.code === '200'){
                    jQuery('#exit_form').after( get_noticebar_html(data.status,data.message) );
                }else if(data.code === '400'){
                    jQuery('#entry_form').after( get_noticebar_html(data.status,data.message) );
                }else if(data.code === '500'){
                    jQuery('#entry_form').after( get_noticebar_html(data.status,data.message) );
                }
            },
            error:function(data){
                console.log('failed');
                jQuery('#exit_form').after( get_noticebar_html(data.status,data.message) );
            }
        })
    });

    //stock exit point tips
    jQuery('#extra_form #submit_extra').on('click',function(event){
        event.preventDefault();
        var extra_tip = jQuery('#extra_tip').val();
        console.log('clicked');
        jQuery.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action:'add_extra_tip',
                'extra_tip':extra_tip
            },
            success:function(data){
                console.log('success');
                if(data.code === '200'){
                    jQuery('#exit_form').after( get_noticebar_html(data.status,data.message) );
                }else if(data.code === '400'){
                    jQuery('#entry_form').after( get_noticebar_html(data.status,data.message) );
                }else if(data.code === '500'){
                    jQuery('#entry_form').after( get_noticebar_html(data.status,data.message) );
                }
            },
            error:function(data){
                console.log('failed');
                jQuery('#exit_form').after( get_noticebar_html(data.status,data.message) );
            }
        })
    });
});

function get_noticebar_html(status,msg){
    var html = '';
    html += '<div id="message" class="updated notice is-dismissible '+status+'">';
    html += '<p>'+msg+'</p>';
    html += '<button type="button" class="notice-dismiss">';
    html += '<span class="screen-reader-text">Dismiss this notice.</span>';
    html += '</button>';
    html += '</div>';
    return html;
}