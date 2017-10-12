<?php 
/**
 * SMOF Options Machine Class
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.0.0
 * @author      Syamil MJ
 */
class Options_Machine {
	/**
	 * PHP5 contructor
	 *
	 * @since 1.0.0
	 */
	function __construct($options) {
		
		$return = $this->nam_tech_settings_machine($options);
		
		$this->Inputs = $return[0];
		$this->Menu = $return[1];
		$this->Defaults = $return[2];
		
	}
	/** 
	 * Sanitize option
	 *
	 * Sanitize & returns default values if don't exist
	 * 
	 * Notes:
	 	- For further uses, you can check for the $value['type'] and performs
	 	  more speficic sanitization on the option
	 	- The ultimate objective of this function is to prevent the "undefined index"
	 	  errors some authors are having due to malformed options array
	 */
	static function sanitize_option( $value ) {
		$defaults = array(
			"name" 		=> "",
			"desc" 		=> "",
			"id" 		=> "",
			"std" 		=> "",
			"mod"		=> "",
			"type" 		=> ""
		);
		$value = wp_parse_args( $value, $defaults );
		return $value;
	}
	/**
	 * Process options data and build option fields
	 *
	 * @uses get_theme_mod()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function nam_tech_settings_machine($options) {
		global $smof_output, $smof_details, $smof_data;
		if (empty($options))
			return;
		
		if (empty($smof_data))
			$smof_data = of_get_options();
		$thenatives = $smof_data;
		$defaults = array();   
	    $counter = 0;
		$menu = '';
		$output = '';
		$update_data = false;
		do_action('nam_tech_settings_machine_before', array(
				'options'	=> $options,
				'smof_data'	=> $smof_data,
			));
		if ($smof_output != "") {
			$output .= $smof_output;
			$smof_output = "";
		}
		
		
		foreach ($options as $value) {
			// sanitize option
			if ($value['type'] != "heading")
				$value = self::sanitize_option($value);
			$counter++;
			$val = '';
			
			//create array of defaults
			if ($value['type'] == 'multicheck'){
				if (is_array($value['std'])){
					foreach($value['std'] as $i=>$key){
						$defaults[$value['id']][$key] = true;
					}
				} else {
						$defaults[$value['id']][$value['std']] = true;
				}
			} else {
				if (isset($value['id'])) $defaults[$value['id']] = $value['std'];
			}
			
			/* condition start */
			if(!empty($smof_data) || !empty($thenatives)){
			
				if (array_key_exists('id', $value) && !isset($smof_data[$value['id']])) {
					$smof_data[$value['id']] = $value['std'];
					if ($value['type'] == "checkbox" && $value['std'] == 0) {
						$smof_data[$value['id']] = 0;
					} else {
						$update_data = true;
					}
				}
				if (array_key_exists('id', $value) && !isset($smof_details[$value['id']])) {
					$smof_details[$value['id']] = $smof_data[$value['id']];
				}
			//Start Heading
			 if ( $value['type'] != "heading")
			 {
			 	$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }
				
				//hide items in checkbox group
				$fold='';
				$fold_val = '';
				if (array_key_exists("fold",$value)) {
					if(($value['type'] == "select" || $value['type'] == "select_google_font") && isset($value['position']) && $value['position'] != ''){
							if($smof_data[$value['fold']] == 0 && $value['position'] != "right" ){
								$fold="f_".$value['fold']." temphide ";
							}
							elseif($smof_data[$value['fold']] == 1 && $value['position'] != "left" ){
								$fold="f_".$value['fold']." temphide ";
							} else {
								$fold="f_".$value['fold']." ";
							}
					} else {
						
						if (isset($smof_data[$value['fold']]) && $smof_data[$value['fold']]) {
							if(array_key_exists("fold_val",$value)){
								if(in_array( $smof_data[$value['fold']],$value['fold_val'] ))
									$fold="f_".$value['fold']." ";
								else $fold="f_".$value['fold']." temphide ";
							} else {
								$fold="f_".$value['fold']." ";
							}
						} else {
							$fold="f_".$value['fold']." temphide ";
						}
						
					}
					
					if(array_key_exists("fold_val",$value)){
						$fold_val = " data-fold_val='".esc_attr(json_encode($value['fold_val']))."'";
					}
				}
	
				if($value['type'] == "info"){
					$output .= '<div id="section-'.$value['id'].'" '.$fold_val.' class="'.$fold.'section section-'.$value['type'].' '. $class .'">'."\n";
					
					//only show header if 'name' value exists
					if($value['name']) $output .= '<h3>'.$value['name']."</h3>"."\n";
					$output .= '<div class="section-right option">'."\n" . '<div class="controls">'."\n";
				}
				else {
					//$output .= '<div class="of-info">'.$info_text.'</div>';
					$output .= '<div id="section-'.$value['id'].'" '.$fold_val.' class="'.$fold.'section section-'.$value['type'].' '. $class .'">'."\n";
					
					//only show header if 'name' value exists
					if($value['name']) $output .= '<div class="section-left"><h3 class="heading">'. $value['name'] .'</h3>'."\n";
					
					if(isset($value['desc']) && trim($value['desc']) != ""){ 
						$output .= '<div class="explain">' . $value['desc'] .'</div>'."\n"; 
					} 
					$output .= '</div><div class="section-right option">'."\n" . '<div class="controls">'."\n";
				}
	
			 } 
			 //End Heading
			//if (!isset($smof_data[$value['id']]) && $value['type'] != "heading")
			//	continue;
			
			//switch statement to handle various options type                              
			switch ( $value['type'] ) {
			
				//text input
				case 'text':
					$t_value = '';
					$t_value = stripslashes($smof_data[$value['id']]);
					
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					
					$output .= '<input class="of-input '.$mini.'" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $t_value .'" />';
				break;
				
				//select option
				case 'select':
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					$position = '';
					if(isset($value['position']) && $value['position'] != '') { $position = $value['position']; }
					$output .= '<div class="select_wrapper ' . $mini . $position. '">';
					$output .= '<select class="select of-input" name="'.$value['id'].'" id="'. $value['id'] .'">';
					foreach ($value['options'] as $select_ID => $option) {
						$theValue = $option;
						if (!is_numeric($select_ID))
							$theValue = $select_ID;
						$output .= '<option id="' . $select_ID . '" value="'.$theValue.'" ' . selected($smof_data[$value['id']], $theValue, false) . ' >'.$option.'</option>';	 
					 } 
					$output .= '</select></div>';
				break;
				
				//textarea option
				case 'textarea':	
					$cols = '8';
					$ta_value = '';
					
					if(isset($value['options'])){
							$ta_options = $value['options'];
							if(isset($ta_options['cols'])){
							$cols = $ta_options['cols'];
							} 
						}
						
						$ta_value = stripslashes($smof_data[$value['id']]);			
						$output .= '<textarea class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea>';		
				break;
				
				//radiobox option
				case "radio":
					$checked = (isset($smof_data[$value['id']])) ? checked($smof_data[$value['id']], $option, false) : '';
					 foreach($value['options'] as $option=>$name) {
						$output .= '<input class="of-input of-radio" name="'.$value['id'].'" type="radio" value="'.$option.'" ' . checked($smof_data[$value['id']], $option, false) . ' /><label class="radio">'.$name.'</label><br/>';				
					}
				break;
				
				//checkbox option
				case 'checkbox':
					if (!isset($smof_data[$value['id']])) {
						$smof_data[$value['id']] = 0;
					}
					
					$fold = '';
					if (array_key_exists("folds",$value)) $fold="fld ";
		
					$output .= '<input type="hidden" class="'.$fold.'checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="0"/>';
					$output .= '<input type="checkbox" class="'.$fold.'checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="1" '. checked($smof_data[$value['id']], 1, false) .' />';
				break;
				
				//multiple checkbox option
				case 'multicheck': 			
					(isset($smof_data[$value['id']]))? $multi_stored = $smof_data[$value['id']] : $multi_stored="";
								
					foreach ($value['options'] as $key => $option) {
						if (!isset($multi_stored[$key])) {$multi_stored[$key] = '';}
						$of_key_string = $value['id'] . '_' . $key;
						$output .= '<input type="checkbox" class="checkbox of-input" name="'.$value['id'].'['.$key.']'.'" id="'. $of_key_string .'" value="1" '. checked($multi_stored[$key], 1, false) .' /><label class="multicheck" for="'. $of_key_string .'">'. $option .'</label><br />';								
					}			 
				break;
				
				// Color picker
				case "color":
					$default_color = '';
					if ( isset($value['std']) ) {
						$default_color = ' data-default-color="' .$value['std'] . '" ';
					}
					$output .= '<input  name="' . $value['id'] . '" id="' . $value['id'] . '" class="of-color"  type="text" value="' . $smof_data[$value['id']] . '"' . $default_color .' />';
		 	
				break;
				
				//tab heading
				case 'heading':
					if($counter >= 2){
					   $output .= '</div>'."\n";
					}
					$icon = '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>';
					if($value['icon']){
						$icon = $value['icon'];
					}
					//custom icon
					$header_class = str_replace(' ','',strtolower($value['name']));
					$jquery_click_hook = str_replace(' ', '', strtolower($value['name']) );
					$jquery_click_hook = "of-option-" . trim(preg_replace('/ +/', '', preg_replace('/[^A-Za-z0-9 ]/', '', urldecode(html_entity_decode(strip_tags($jquery_click_hook))))));
					
					$menu .= '<li class="'. $header_class .'"></i><a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'">'. $icon .'<span>'.  $value['name'] .'</span></a></li>';
					$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
				break;

				//Switch option
				case 'switch':
					if (!isset($smof_data[$value['id']])) {
						$smof_data[$value['id']] = 0;
					}
					
					$fold = '';
					if (array_key_exists("folds",$value)) $fold="s_fld ";
					
					$cb_enabled = $cb_disabled = '';//no errors, please
					
					//Get selected
					if ($smof_data[$value['id']] == 1){
						$cb_enabled = ' selected';
						$cb_disabled = '';
					}else{
						$cb_enabled = '';
						$cb_disabled = ' selected';
					}
					
					//Label ON
					if(!isset($value['on'])){
						$on = "On";
					}else{
						$on = $value['on'];
					}
					
					//Label OFF
					if(!isset($value['off'])){
						$off = "Off";
					}else{
						$off = $value['off'];
					}
					
					$output .= '<p class="switch-options">';
						$output .= '<label class="'.$fold.'cb-enable'. $cb_enabled .'" data-id="'.$value['id'].'"><span>'. $on .'</span></label>';
						$output .= '<label class="'.$fold.'cb-disable'. $cb_disabled .'" data-id="'.$value['id'].'"><span>'. $off .'</span></label>';
						
						$output .= '<input type="hidden" class="'.$fold.'checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="0"/>';
						$output .= '<input type="checkbox" id="'.$value['id'].'" class="'.$fold.'checkbox of-input main_checkbox" name="'.$value['id'].'"  value="1" '. checked($smof_data[$value['id']], 1, false) .' />';
						
					$output .= '</p>';
					
				break;
				
				//Switchs option
				case 'switchs':
					if (!isset($smof_data[$value['id']])) {
						$smof_data[$value['id']] = 0;
					}
					
					$fold = '';
					if (array_key_exists("folds",$value)) $fold="s_fld ";
					$cb_one = $cb_two = '';//no errors, please
					
					//Get selected
					if ($smof_data[$value['id']] == 1){
						$cb_one = ' selected';
						$cb_disabled = '';
					}else{
						$cb_one = '';
						$cb_two = ' selected';
					}
					
					//Label ON
					if(!isset($value['on'])){
						$on = "On";
					}else{
						$on = $value['on'];
					}
					
					//Label OFF
					if(!isset($value['off'])){
						$off = "Off";
					}else{
						$off = $value['off'];
					}
					
					$output .= '<p class="switchs-options">';
						$output .= '<label class="'.$fold.'cb-one'. $cb_one .'" data-id="'.$value['id'].'"><span>'. $on .'</span></label>';
						$output .= '<label class="'.$fold.'cb-two'. $cb_two.'" data-id="'.$value['id'].'"><span>'. $off .'</span></label>';
						
						$output .= '<input type="hidden" class="'.$fold.'checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="0"/>';
						$output .= '<input type="checkbox" id="'.$value['id'].'" class="'.$fold.'checkbox of-input main_checkbox" name="'.$value['id'].'"  value="1" '. checked($smof_data[$value['id']], 1, false) .' />';
						
					$output .= '</p>';
					
				break;
				case "upload":
				case "media":
					if(!isset($value['mod'])) $value['mod'] = '';
					$u_val = '';
					if($smof_data[$value['id']]){
						$u_val = stripslashes($smof_data[$value['id']]);
					}
					$output .= Options_Machine::nam_tech_settings_media_uploader_function($value['id'],$u_val, $value['mod']);
					
				break;
				
				
				case "iframe":
					$t_value = '';
					$t_value = stripslashes($smof_data[$value['id']]);
					
					$mini ='';
					if(!isset($value['mod'])) $value['mod'] = '';
					if($value['mod'] == 'mini') { $mini = 'mini';}
					$output.= '<div class="iframe-options">';
					$output.= '<div class="iframe-input">';
					$output.= '<input class="of-input '.$mini.'" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $t_value .'" />';
					$output.= '</div>';
					if($t_value){
						$iframe = strpos($t_value,'watch?v=');
						if($iframe){
							$iframe = str_replace('watch?v=', 'embed/', $t_value);
							$output.= '<div class="of-iframe-display">';
							$output.= '<iframe src="'.$iframe.'" width="100%"></iframe>';
							$output.= '</div>';
						}
					}
					$output.= '</div>';
					
				break;
				
			}
			do_action('nam_tech_settings_machine_loop', array(
					'options'	=> $options,
					'smof_data'	=> $smof_data,
					'defaults'	=> $defaults,
					'counter'	=> $counter,
					'menu'		=> $menu,
					'output'	=> $output,
					'value'		=> $value
				));
			if ($smof_output != "") {
				$output .= $smof_output;
				$smof_output = "";
			}
			
			//description of each option
			if ( $value['type'] != 'heading') { 
				$output .= '</div><div class="clear"> </div></div></div>'."\n";
				}
			
			} /* condition empty end */
		   
		}
		if ($update_data == true) {
			of_save_options($smof_data);
		}
		
	    $output .= '</div>';
	    do_action('nam_tech_settings_machine_after', array(
					'options'		=> $options,
					'smof_data'		=> $smof_data,
					'defaults'		=> $defaults,
					'counter'		=> $counter,
					'menu'			=> $menu,
					'output'		=> $output,
					'value'			=> $value
				));
		if ($smof_output != "") {
			$output .= $smof_output;
			$smof_output = "";
		}
	    return array($output,$menu,$defaults);
	    
	}
	/**
	 * Native media library uploader
	 *
	 * @uses get_theme_mod()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	 
	public static function nam_tech_settings_import_function($id){
		$smof_data = of_get_options();
		ob_start();
		?>
			<button style="position:relative; display: inline-table; margin: 0px auto;" data-pa-id="<?php echo esc_attr($id);?>" data-id="<?php echo esc_attr($id);?>_import" type="button" class="button wp_import_button" name="<?php echo esc_attr($id);?>_import_btn"><i class="fa fa-upload"></i> <?php _e('Import', "wpdance")?></button>
			<input data-pa-id="<?php echo esc_attr($id);?>" style="position:relative; float: left; width: 65%; display:none;" data-action="<?php echo ADMIN_DIR?>classes/upload_xml.php" class="wp_import_input" name="<?php echo esc_attr($id);?>_import" id="<?php echo esc_attr($id);?>_import" type="file" />
			<button style="position:relative; display: inline-table;" data-pa-id="<?php echo esc_attr($id);?>" data-action="<?php echo ADMIN_DIR?>classes/export_xml.php" type="button" class="button-primary wp_export_input" name="<?php echo esc_attr($id);?>_export" title="<?php _e('Exporting the colour being applied', "wpdance")?>" id="<?php echo esc_attr($id);?>_export"><i class="fa fa-download"></i> <?php _e('Export', "wpdance")?></button>
			<button style="position:relative; display: inline-table;" type="button" class="button-remove wp_remove_button" data-pa-id="<?php echo esc_attr($id);?>" name="<?php echo esc_attr($id);?>_remove" id="<?php echo esc_attr($id);?>_remove"><i class="fa fa-trash-o"></i> <?php _e('Remove', "wpdance")?></button>
		<?php
		$uploader = ob_get_contents();
		ob_end_clean();
		return $uploader;
	}
	public static function nam_tech_settings_media_uploader_function($id,$std,$mod){
	    $thenatives = of_get_options();
	    $smof_data = of_get_options();
		
		$uploader = '';
		$upload = "";
		if (isset($smof_data[$id]))
	    	$upload = $smof_data[$id];
		$hide = '';
		
		if ($mod == "min") {$hide ='hide';}
		
	    if ( $upload != "") { $val = $upload; } else {$val = $std;}
	    
		$uploader .= '<input class="'.$hide.' upload of-input" name="'. $id .'" id="'. $id .'_upload" value="'. $val .'" />';	
		
		//Upload controls DIV
		$uploader .= '<div class="upload_button_div">';
		//If the user has WP3.5+ show upload/remove button
		if ( function_exists( 'wp_enqueue_media' ) ) {
			$uploader .= '<span class="button media_upload_button" id="'.$id.'">Upload</span>';
			
			if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
			$uploader .= '<span class="button remove-image '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
		}
		else 
		{
			$output .= '<p class="upload-notice"><i>Upgrade your version of WordPress for full media support.</i></p>';
		}
		$uploader .='</div>' . "\n";
		//Preview
		$uploader .= '<div class="screenshot">';
		if(!empty($upload)){	
	    	$uploader .= '<a class="of-uploaded-image" href="'. $upload . '">';
	    	$uploader .= '<img class="of-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
	    	$uploader .= '</a>';			
			}
		$uploader .= '</div>';
		$uploader .= '<div class="clear"></div>' . "\n"; 
	
		return $uploader;
		
	}
	/**
	 * Drag and drop slides manager
	 *
	 * @uses get_theme_mod()
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function nam_tech_settings_slider_function($id,$std,$oldorder,$order)
    {
        $thenatives = of_get_options();
        $smof_data = of_get_options();
        $slider = '';
        $slide = array();
        if (isset($smof_data[$id]))
            $slide = $smof_data[$id];
        if (isset($slide[$oldorder])) {
            $val = $slide[$oldorder];
        } else {
            $val = $std;
        }
        //initialize all vars
        $slidevars = array('title', 'url', 'link', 'description');
        foreach ($slidevars as $slidevar) {
            if (!isset($val[$slidevar])) {
                $val[$slidevar] = '';
            }
        }
        //begin slider interface
        if (!empty($val['title'])) {
            $slider .= '<li><div class="slide_header"><strong>' . stripslashes($val['title']) . '</strong>';
        } else {
            $slider .= '<li><div class="slide_header"><strong>Slide ' . $order . '</strong>';
        }
        $slider .= '<input type="hidden" class="slide of-input order" name="' . $id . '[' . $order . '][order]" id="' . $id . '_' . $order . '_slide_order" value="' . $order . '" />';
        $slider .= '<a class="slide_edit_button" href="#">Edit</a></div>';
        $slider .= '<div class="slide_body">';
        $slider .= '<label>Title</label>';
        $slider .= '<input class="slide of-input of-slider-title" name="' . $id . '[' . $order . '][title]" id="' . $id . '_' . $order . '_slide_title" value="' . stripslashes($val['title']) . '" />';
        $slider .= '<label>Image URL</label>';
        $slider .= '<input class="upload slide of-input" name="' . $id . '[' . $order . '][url]" id="' . $id . '_' . $order . '_slide_url" value="' . $val['url'] . '" />';
        $slider .= '<div class="upload_button_div"><span class="button media_upload_button" id="' . $id . '_' . $order . '">Upload</span>';
        if (!empty($val['url'])) {
            $hide = '';
        } else {
            $hide = 'hide';
        }
        $slider .= '<span class="button remove-image ' . $hide . '" id="reset_' . $id . '_' . $order . '" title="' . $id . '_' . $order . '">Remove</span>';
        $slider .= '</div>' . "\n";
        $slider .= '<div class="screenshot">';
        if (!empty($val['url'])) {
            $slider .= '<a class="of-uploaded-image" href="' . $val['url'] . '">';
            $slider .= '<img class="of-option-image" id="image_' . $id . '_' . $order . '" src="' . $val['url'] . '" alt="" />';
            $slider .= '</a>';
        }
        $slider .= '</div>';
        $slider .= '<label>Link URL (optional)</label>';
        $slider .= '<input class="slide of-input" name="' . $id . '[' . $order . '][link]" id="' . $id . '_' . $order . '_slide_link" value="' . $val['link'] . '" />';
        $slider .= '<label>Description (optional)</label>';
        $slider .= '<textarea class="slide of-input" name="' . $id . '[' . $order . '][description]" id="' . $id . '_' . $order . '_slide_description" cols="8" rows="8">' . stripslashes($val['description']) . '</textarea>';
        $slider .= '<a class="slide_delete_button" href="#">Delete</a>';
        $slider .= '<div class="clear"></div>' . "\n";
        $slider .= '</div>';
        $slider .= '</li>';
        return $slider;
    }
}//end Options Machine class
?>