jQuery("document").ready(function($){
	$('.upload-btn').click(function(e) {
        e.preventDefault();
        var $this = $(this);
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $this.siblings('.upload-field').val(image_url);
            if(image_url!=''){
            	$this.siblings('.remove-upload-btn').show();
            	$this.siblings('.upload-image').html('<img src="'+image_url+'" width="200px" style="margin-top: 15px;" />')
            }
        });
    });
    $('.remove-upload-btn').click(function(e) {
    	e.preventDefault();
    	var $this = $(this);
    	$this.siblings('.upload-field').val('');
    	$this.siblings('.upload-image').html('');
    	$this.hide();
    });
});