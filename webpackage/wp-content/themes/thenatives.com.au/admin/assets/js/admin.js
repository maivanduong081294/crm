jQuery("document").ready(function($){
	$(document).on('click','.upload-btn',function(e) {
        e.preventDefault();
        var $this = $(this);
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $this.siblings('.upload-field').val(image_url);
            if(image_url){
            	$this.siblings('.remove-upload-btn').show();
            	$this.siblings('.upload-image').html('<img src="'+image_url+'" style="margin-top: 15px;" />')
            }
        });
    });
    $(document).on('click','.remove-upload-btn',function(e) {
    	e.preventDefault();
    	var $this = $(this);
    	$this.siblings('.upload-field').val('');
    	$this.siblings('.upload-image').html('');
    	$this.hide();
    });
    $(document).on('click','.repeater-field-add',function () {
        var $this = $(this);
        var args = $this.parents('.repeater-field').children('.repeater-button-add').children('.repeater-args').val();
        var key = $this.parents('.repeater-field').children('.repeater-field-list').children().length;
        if($this.parent('.repeater-field-item-button').length) {
            key = $this.parents('.repeater-field-item').index();
            var list = $this.parents('.repeater-field-list');
            var index = 0;
            var name = $this.parent().data('type');
            var check = false;
            list.children().each(function () {
                var iCurrent = $(this).attr('data-item');
                if(iCurrent >= key) {
                    var newIndex = index+1;
                    if(!check) {
                        $(this).parents('.repeater-field').children('.repeater-field-list').children().eq(index).find('.wp-editor-area').each(function () {
                            tinyMCE.execCommand('mceRemoveEditor', false, $(this).attr('id'));
                        });
                        check = true;
                    }
                    $(this).parents('.repeater-field').children('.repeater-field-list').children().eq(newIndex).find('.wp-editor-area').each(function () {
                        tinyMCE.execCommand('mceRemoveEditor', false, $(this).attr('id'));
                    });

                    var html = $(this).html();
                    var string = name+'-'+iCurrent;
                    string = new RegExp(string, "gi");
                    var replace = name+'-'+newIndex;
                    html = html.replace(string,replace);
                    $(this).html(html);
                    if($(this).find('[name]').length){
                        $(this).find('[name]').each(function () {
                            var fname = $(this).attr('name');
                            fname = fname.split(iCurrent+']')[1];
                            $(this).attr('name',name+'['+newIndex+']'+fname);
                            if($(this).hasClass('wp-editor-area')){
                                tinyMCE.execCommand('mceAddEditor', false, $(this).attr('id'));
                                quicktags({id : $(this).attr('id')});
                            }
                        });
                    }
                    $(this).attr('data-item',newIndex);
                }
                index++;
            });
        }
        $.ajax({
            url: ajax_object.url,
            type: 'post',
            data: {
                action: 'repeater_field_add',
                args: args,
                key: key,
            },
            beforeSend: function () {

            },
            success: function (html) {
                if($this.parent('.repeater-field-item-button').length) {
                    list.children().eq(key).before(html);
                    list.children().eq(key).find('.wp-editor-area').each(function () {
                        tinyMCE.execCommand('mceRemoveEditor', false, $(this).attr('id'));
                        tinyMCE.execCommand('mceAddEditor', false, $(this).attr('id'));
                        quicktags({id : $(this).attr('id')});
                    });
                    var index = 0;
                    list.children().each(function () {
                        var iCurrent = $(this).data('item');
                        if (iCurrent >= key) {
                            $(this).find('.repeater-field-item-title span').text('#'+(index+1));
                        }
                        index++;
                    });
                }
                else {
                    $this.parents('.repeater-field').children('.repeater-field-list').append(html);
                    $this.parents('.repeater-field').children('.repeater-field-list').children().eq(key).find('.wp-editor-area').each(function () {
                        tinyMCE.execCommand('mceRemoveEditor', false, $(this).attr('id'));
                        tinyMCE.execCommand('mceAddEditor', false, $(this).attr('id'));
                        quicktags({id : $(this).attr('id')});
                    });
                }
            }
        });
    });
    $(document).on('click','.repeater-field-remove',function () {
        var $this = $(this);
        var current = $this.parents('.repeater-field-item').index();
        var index = 0;
        var list = $this.parents('.repeater-field-list');
        var name = $this.parent().data('type');
        var check = false;
        list.children().each(function () {
            var iCurrent = $(this).attr('data-item');

            if(check) {
                $(this).parents('.repeater-field').children('.repeater-field-list').children().eq(index).find('.wp-editor-area').each(function () {
                    tinyMCE.execCommand('mceRemoveEditor', false, $(this).attr('id'));
                });

                var html = $(this).html();
                var string = name+'-'+iCurrent;
                string = new RegExp(string, "gi");
                var replace = name+'-'+index;
                html = html.replace(string,replace);
                $(this).html(html);
                if($(this).find('[name]').length){
                    $(this).find('[name]').each(function () {
                        var fname = $(this).attr('name');
                        fname = fname.split(iCurrent+']')[1];
                        $(this).attr('name',name+'['+index+']'+fname);
                        if($(this).hasClass('wp-editor-area')){
                            tinyMCE.execCommand('mceRemoveEditor', false, $(this).attr('id'));
                            tinyMCE.execCommand('mceAddEditor', false, $(this).attr('id'));
                            quicktags({id : $(this).attr('id')});
                        }
                    });
                }
                $(this).attr('data-item',index);
                $(this).find('.repeater-field-item-title span').text('#'+(index+1));
            }

            if(iCurrent == $this.parents('.repeater-field-item').data('item')){
                check = true;
                $(this).parents('.repeater-field').children('.repeater-field-list').children().eq(index).find('.wp-editor-area').each(function () {
                    tinyMCE.execCommand('mceRemoveEditor', false, $(this).attr('id'));
                });
                $this.parents('.repeater-field-item').remove();
            }
            else {
                index++;
            }
        });
    });

    $(document).on('click','.repeater-field-open',function () {
       $(this).toggleClass('active');
       $(this).parents('.repeater-field-item-header').siblings('.repeater-field-item-content').slideToggle();
    });
});