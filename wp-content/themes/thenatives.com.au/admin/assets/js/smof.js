jQuery.noConflict(),jQuery(document).ready(function(e){function t(e){return decodeURI((RegExp(e+"=(.+?)(&|$)").exec(location.search)||[,""])[1])}function i(t){var i=t;return this.timer&&clearTimeout(i.timer),this.timer=setTimeout(function(){e(i).parent().prev().find("strong").text(i.value)},100),!0}function o(t,i){var o=e(t).val(),a="style_link_"+i,n=i+"_ggf_previewer";if(o)if(e("."+n).fadeIn(),"none"!==o&&"Select a font"!==o){e("."+a).remove();var s=o.replace(/\s+/g,"+");e("head").append('<link href="http://fonts.googleapis.com/css?family='+s+'" rel="stylesheet" type="text/css" class="'+a+'">'),e("."+n).css("font-family",o+", sans-serif")}else e("."+n).css("font-family",""),e("."+n).fadeOut()}function a(t,i){e(".uploaded-file");var o,a=e(this);t.preventDefault(),o?o.open():((o=wp.media({title:a.data("choose"),button:{text:a.data("update"),close:!1}})).on("select",function(){var e=o.state().get("selection").first();o.close(),i.find(".upload").val(e.attributes.url),"image"==e.attributes.type&&i.find(".screenshot").empty().hide().append('<img class="of-option-image" src="'+e.attributes.url+'">').slideDown("fast"),i.find(".media_upload_button").unbind(),i.find(".remove-image").show().removeClass("hide"),i.find(".of-background-properties").slideDown(),s()}),o.open())}function n(t){t.find(".remove-image").hide().addClass("hide"),t.find(".upload").val(""),t.find(".of-background-properties").hide(),t.find(".screenshot").slideUp(),t.find(".remove-file").unbind(),e(".section-upload .upload-notice").length>0&&e(".media_upload_button").remove(),s()}function s(){e(".remove-image, .remove-file").on("click",function(){n(e(this).parents(".section-upload, .section-media, .slide_body"))}),e(".media_upload_button").unbind("click").click(function(t){a(t,e(this).parents(".section-upload, .section-media, .slide_body"))})}if(jQuery(".fld").on("click",function(){var t=".f_"+this.id;e(t).slideToggle("normal","swing")}),jQuery(".wd-img-choose").on("click",function(){var e=".f_"+jQuery(this).data("id"),t=jQuery(this).find("input[type=radio]").val(),i=jQuery(e).data("fold_val");if(console.log(i),void 0!==i){var o=!1;jQuery.each(i,function(e,i){t==i&&(o=!0)}),o?jQuery(e).slideDown("normal","swing"):jQuery(e).slideUp("normal","swing")}}),e(".of-color").wpColorPicker(),e("#js-warning").hide(),e(".group").hide(),""!=t("tab")&&e.cookie("of_current_opt","#"+t("tab"),{expires:7,path:"/"}),null===e.cookie("of_current_opt"))e(".group:first").fadeIn("fast"),e("#of-nav li:first").addClass("current");else{var r=e("#hooks").html();r=jQuery.parseJSON(r),e.each(r,function(t,i){e.cookie("of_current_opt")=="#of-option-"+i&&(e(".group#of-option-"+i).fadeIn(),e("#of-nav li."+i).addClass("current"))})}e("#of-nav li a").on("click",function(t){e("#of-nav li").removeClass("current"),e(this).parent().addClass("current");var i=e(this).attr("href");return e.cookie("of_current_opt",i,{expires:7,path:"/"}),e(".group").hide(),e(i).fadeIn("fast"),!1});var l=0;e("#expand_options").on("click",function(){0==l?(l=1,e("#of_container #of-nav").hide(),e("#of_container #content").width(755),e("#of_container .group").add("#of_container .group h2").show(),e(this).removeClass("expand"),e(this).addClass("close"),e(this).text("Close")):(l=0,e("#of_container #of-nav").show(),e("#of_container #content").width(595),e("#of_container .group").add("#of_container .group h2").hide(),e("#of_container .group:first").show(),e("#of_container #of-nav li").removeClass("current"),e("#of_container #of-nav li:first").addClass("current"),e(this).removeClass("close"),e(this).addClass("expand"),e(this).text("Expand"))}),e.fn.center=function(){return this.animate({top:(e(window).height()-this.height()-200)/2+e(window).scrollTop()+"px"},100),this.css("left",250),this},e("#of-popup-save").center(),e("#of-popup-reset").center(),e("#of-popup-fail").center(),e("#of-popup-loading").center(),e(window).scroll(function(){e("#of-popup-save").center(),e("#of-popup-reset").center(),e("#of-popup-fail").center(),e("#of-popup-loading").center()}),e(".wp_import_button").live("click",function(t){var i=e(this).attr("data-id");e("#"+i).click()}),e(".wp_import_input").live("change",function(t){var i=t.target.files,o=new FormData,a=e(this);o.append("action","import_color_theme"),o.append("file_upload",i[0]);var n=e(this).attr("data-pa-id");e(this).attr("data-action");e.ajax({url:ajaxurl,type:"POST",data:o,dataType:"json",cache:!1,processData:!1,contentType:!1,beforeSend:function(e){a.parents(".action_tool").find("button, input").attr("disabled","disabled")},success:function(t){"success"==t.status?e("#section-"+n+" .of-radio-img-selected").click():(alert(t.msg),a.val("")),a.parents(".action_tool").find("button, input").removeAttr("disabled")}})}),e(".wp_remove_button").live("click",function(t){var i=e("#section-wd_color_scheme .of-radio-img-selected").siblings(".of-radio-img-radio").val(),o=e(this).attr("data-pa-id"),a=e(this);e.ajax({url:ajaxurl,type:"POST",dataType:"json",data:{action:"remove_color_theme",file:i,pa_id:o},beforeSend:function(e){a.parents(".action_tool").find("button, input").attr("disabled","disabled")},success:function(t){switch(t.status){case"error":alert(t.msg);break;case"success":e("#section-"+o+' input[value="'+t.msg+'"]').parent().find("img.of-radio-img-img").click()}a.parents(".action_tool").find("button, input").removeAttr("disabled")}})}),e(".wp_export_input").live("click",function(t){var i=e(this).attr("data-pa-id"),o=e(this);e.ajax({url:ajaxurl,type:"POST",data:{action:"export_color_theme",slug:i},beforeSend:function(e){o.parents(".action_tool").find("button, input").attr("disabled","disabled")},success:function(e){"error"!==e&&(window.location=e),o.parents(".action_tool").find("button, input").removeAttr("disabled")}})}),e(".of-radio-img-img").live("click",function(){var t=e(this),i=e(this).siblings(".of-radio-img-radio").val();if(e(this).closest("#of-option-stylingoptions").length>0){var o=e("#of-popup-loading");o.fadeIn(0);var a={action:"tab_refesh",file:i,security:e("#security").val()};e.post(ajaxurl,a,function(t){if(-1==t){o.hide();var i=e("#of-popup-fail");i.fadeIn(),window.setTimeout(function(){i.fadeOut()},2e3)}else window.setTimeout(function(){console.log(JSON.parse(t)),e("#of-option-stylingoptions").replaceWith('<div class="group" id="of-option-stylingoptions" style="display: block;"><h2>Styling Options</h2>'+JSON.parse(t)),e(".of-color").wpColorPicker(),e(".of-radio-img-label").hide(),e(".of-radio-img-img").show(),e(".of-radio-img-radio").hide(),s(),styleSelect.init(),o.fadeOut()},1e3)})}t.parent().parent().find(".of-radio-img-img").removeClass("of-radio-img-selected"),t.parents(".controls").find(".item_description > *").hide(),t.parents(".controls").find(".item_description ."+i).show(),t.addClass("of-radio-img-selected")}),e(".of-radio-img-label").hide(),e(".of-radio-img-img").show(),e(".of-radio-img-radio").hide(),e(".of-radio-tile-img").on("click",function(){e(this).parent().parent().find(".of-radio-tile-img").removeClass("of-radio-tile-selected"),e(this).addClass("of-radio-tile-selected")}),e(".of-radio-tile-label").hide(),e(".of-radio-tile-img").show(),e(".of-radio-tile-radio").hide(),function(e){styleSelect={init:function(){e(".select_wrapper").each(function(){e(this).prepend("<span>"+e(this).find(".select option:selected").text()+"</span>")}),e(".select").live("change",function(){e(this).prev("span").replaceWith("<span>"+e(this).find("option:selected").text()+"</span>")}),e(".select").bind(e.browser.msie?"click":"change",function(t){e(this).prev("span").replaceWith("<span>"+e(this).find("option:selected").text()+"</span>")})}},e(document).ready(function(){styleSelect.init()})}(jQuery),e(".slide_body").hide(),e(".slide_edit_button").live("click",function(){return e(this).parent().toggleClass("active").next().slideToggle("fast"),!1}),e(".of-slider-title").live("keyup",function(){i(this)}),e(".slide_delete_button").live("click",function(){return!!confirm("Are you sure you wish to delete this slide?")&&(e(this).parents("li").animate({opacity:.25,height:0},500,function(){e(this).remove()}),!1)}),e(".slide_add_button").live("click",function(){var t=e(this).prev(),i=t.attr("id"),o=e("#"+i+" li").find(".order").map(function(){var e=this.id;return e=e.replace(/\D/g,""),e=parseFloat(e)}).get(),a=Math.max.apply(Math,o);a<1&&(a=0);var n=a+1,r='<li class="temphide"><div class="slide_header"><strong>Slide '+n+'</strong><input type="hidden" class="slide of-input order" name="'+i+"["+n+'][order]" id="'+i+"_slide_order-"+n+'" value="'+n+'"><a class="slide_edit_button" href="#">Edit</a></div><div class="slide_body" style="display: none; "><label>Title</label><input class="slide of-input of-slider-title" name="'+i+"["+n+'][title]" id="'+i+"_"+n+'_slide_title" value=""><label>Image URL</label><input class="upload slide of-input" name="'+i+"["+n+'][url]" id="'+i+"_"+n+'_slide_url" value=""><div class="upload_button_div"><span class="button media_upload_button" id="'+i+"_"+n+'">Upload</span><span class="button remove-image hide" id="reset_'+i+"_"+n+'" title="'+i+"_"+n+'">Remove</span></div><div class="screenshot"></div><label>Link URL (optional)</label><input class="slide of-input" name="'+i+"["+n+'][link]" id="'+i+"_"+n+'_slide_link" value=""><label>Description (optional)</label><textarea class="slide of-input" name="'+i+"["+n+'][description]" id="'+i+"_"+n+'_slide_description" cols="8" rows="8"></textarea><a class="slide_delete_button" href="#">Delete</a><div class="clear"></div></div></li>';return t.append(r),t.find(".temphide").fadeIn("fast",function(){e(this).removeClass("temphide")}),s(),!1}),jQuery(".slider").find("ul").each(function(){var t=jQuery(this).attr("id");e("#"+t).sortable({placeholder:"placeholder",opacity:.6,handle:".slide_header",cancel:"a"})}),jQuery(".sorter").each(function(){var t=jQuery(this).attr("id");e("#"+t).find("ul").sortable({items:"li",placeholder:"placeholder",connectWith:".sortlist_"+t,opacity:.6,update:function(){e(this).find(".position").each(function(){var i=e(this).parent().attr("id"),o=e(this).parent().parent().attr("id");o=o.replace(t+"_","");var a=e(this).parent().parent().parent().attr("id");e(this).prop("name",a+"["+o+"]["+i+"]")})}})}),e("#of_backup_button").live("click",function(){if(confirm("Click OK to backup your current saved options.")){e(this),e(this).attr("id");var t={action:"of_ajax_post_action",type:"backup_options",security:e("#security").val()};e.post(ajaxurl,t,function(t){if(-1==t){var i=e("#of-popup-fail");i.fadeIn(),window.setTimeout(function(){i.fadeOut()},2e3)}else e("#of-popup-save").fadeIn(),window.setTimeout(function(){location.reload()},1e3)})}return!1}),e("#of_restore_button").live("click",function(){if(confirm("'Warning: All of your current options will be replaced with the data from your last backup! Proceed?")){e(this),e(this).attr("id");var t={action:"of_ajax_post_action",type:"restore_options",security:e("#security").val()};e.post(ajaxurl,t,function(t){if(-1==t){var i=e("#of-popup-fail");i.fadeIn(),window.setTimeout(function(){i.fadeOut()},2e3)}else e("#of-popup-save").fadeIn(),window.setTimeout(function(){location.reload()},1e3)})}return!1}),e("#of_import_button").live("click",function(){if(confirm("Click OK to import options.")){e(this),e(this).attr("id");var t={action:"of_ajax_post_action",type:"import_options",security:e("#security").val(),data:e("#export_data").val()};e.post(ajaxurl,t,function(t){var i=e("#of-popup-fail"),o=e("#of-popup-save");-1==t?(i.fadeIn(),window.setTimeout(function(){i.fadeOut()},2e3)):(o.fadeIn(),window.setTimeout(function(){location.reload()},1e3))})}return!1}),e("#of_save").live("click",function(){var t=e("#security").val();e(".ajax-loading-img").fadeIn();var i=e('#of_form :input[name][name!="security"][name!="of_reset"]').serialize();e("#of_form :input[type=checkbox]").each(function(){this.checked||(i+="&"+this.name+"=0")});var o={type:"save",action:"of_ajax_post_action",security:t,data:i};return e.post(ajaxurl,o,function(t){var i=e("#of-popup-save"),o=e("#of-popup-fail");e(".ajax-loading-img").fadeOut(),1==t?i.fadeIn():o.fadeIn(),window.setTimeout(function(){i.fadeOut(),o.fadeOut()},2e3)}),!1}),e("#of_reset").on("click",function(){if(confirm("Click OK to reset. All settings will be lost and replaced with default settings!")){var t=e("#security").val();e(".ajax-reset-loading-img").fadeIn();var i={type:"reset",action:"of_ajax_post_action",security:t};e.post(ajaxurl,i,function(t){var i=e("#of-popup-reset"),o=e("#of-popup-fail");e(".ajax-reset-loading-img").fadeOut(),1==t?(i.fadeIn(),window.setTimeout(function(){location.reload()},1e3)):(o.fadeIn(),window.setTimeout(function(){o.fadeOut()},2e3))})}return!1}),jQuery().tipsy&&e(".tooltip, .typography-size, .typography-height, .typography-face, .typography-style, .of-typography-color").tipsy({fade:!0,gravity:"s",opacity:.7}),jQuery(".smof_sliderui").each(function(){var e=jQuery(this),t="#"+e.data("id"),i=parseInt(e.data("val")),o=parseInt(e.data("min")),a=parseInt(e.data("max")),n=parseInt(e.data("step"));e.slider({value:i,min:o,max:a,step:n,range:"min",slide:function(e,i){jQuery(t).val(i.value)}})}),jQuery(".cb-enable").click(function(){var t=e(this).parents(".switch-options");jQuery(".cb-disable",t).removeClass("selected"),jQuery(this).addClass("selected"),jQuery(".main_checkbox",t).attr("checked",!0);var i=".f_"+jQuery(this).data("id");jQuery(i).each(function(){"[0]"!=jQuery(this).attr("data-fold_val")?(jQuery(this).css("display","none"),jQuery(this).removeClass("temphide"),jQuery(this).slideDown("normal",function(){jQuery(this).css("display","flex")})):jQuery(i).slideUp("normal","swing")})}),jQuery(".cb-disable").click(function(){var t=e(this).parents(".switch-options");jQuery(".cb-enable",t).removeClass("selected"),jQuery(this).addClass("selected"),jQuery(".main_checkbox",t).attr("checked",!1);var i=".f_"+jQuery(this).data("id");jQuery(i).each(function(){"[0]"==jQuery(this).attr("data-fold_val")?(jQuery(this).css("display","none"),jQuery(this).removeClass("temphide"),setTimeout(function(){jQuery(this).css("display","flex")},1),jQuery(this).slideDown("normal",function(){jQuery(this).css("display","flex")})):jQuery(i).slideUp("normal","swing")})}),jQuery(".cb-one").click(function(){var t=e(this).parents(".switchs-options");jQuery(".cb-two",t).removeClass("selected"),jQuery(this).addClass("selected"),jQuery(".main_checkbox",t).attr("checked",!0);var i=".f_"+jQuery(this).data("id");jQuery(i).slideUp("normal","swing"),jQuery(i).find(".select_wrapper.left").length>0&&jQuery(i).has(".select_wrapper.left").slideDown("normal","swing")}),jQuery(".cb-two").click(function(){var t=e(this).parents(".switchs-options");jQuery(".cb-one",t).removeClass("selected"),jQuery(this).addClass("selected"),jQuery(".main_checkbox",t).attr("checked",!1);var i=".f_"+jQuery(this).data("id");jQuery(i).slideUp("normal","swing"),jQuery(i).find(".select_wrapper.right").length>0&&jQuery(i).has(".select_wrapper.right").slideDown("normal","swing")}),(e.browser.msie&&e.browser.version<10||e.browser.opera)&&e(".cb-enable span, .cb-disable span").find().attr("unselectable","on"),jQuery(".google_font_select").each(function(){o(this,jQuery(this).attr("id"))}),jQuery(".google_font_select").change(function(){o(this,jQuery(this).attr("id"))}),s()});