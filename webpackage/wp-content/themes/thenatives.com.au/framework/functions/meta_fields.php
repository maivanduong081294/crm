<?php
function get_metabox_field($args){
    ob_start();
    $name = (isset($args['name']) && $args['name'])?$args['name']:'';
    $id = (isset($args['id']) && $args['id'])?$args['id']:$name;
    $value = (isset($args['value']) && $args['value'])?$args['value']:'';
    if($name) {
        ?>
        <div class="thenatives-post-field <?php echo $id; ?>-field">
            <div class="thenatives-post-field-title">
                <label for="<?php echo $id;if($args['type']=='upload')echo '-upload-btn'; ?>"><?php echo $args['title']; ?></label>
            </div>
            <div class="thenatives-post-field-content <?php echo $args['type']; ?>-field">
                <?php
                switch ($args['type']) {
                    case 'textarea' :
                        ?>
                        <textarea name="<?php echo $name; ?>" class="thenatives-post-field-input"
                                  id="<?php echo $id; ?>" rows="5"><?php if ($value) echo $value; ?></textarea>
                        <?php
                        break;
                    case 'editor' :
                        ?>
                        <?php
                        $editor_setting = array(
                            'textarea_rows' => 8,
                            'textarea_name' => $name,
                        );
                        wp_editor($value, $id, $editor_setting);
                        ?>
                        <?php
                        break;
                    case 'select' :
                        if(count($args['options'])) {
                            ?>
                            <select name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="thenatives-post-field-input">
                                <?php foreach ($args['options'] as $key=>$option): ?>
                                    <option value="<?php echo $key; ?>" <?php selected( $key, $value ); ?>><?php echo $option; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php
                        }
                        break;
                    case 'category' :
                        $categories = get_categories( array(
                            'orderby' => 'name',
                            'order'   => 'ASC'
                        ) );
                        ?>
                        <select name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="thenatives-post-field-input">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->term_id; ?>" <?php selected( $category->term_id, $value ); ?>><?php echo $category->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php
                        break;
                    case 'upload' :
                        ?>
                        <input type="text" name="<?php echo $name; ?>" class="thenatives-post-field-input upload-field"
                               id="<?php echo $id; ?>" value="<?php if ($value) echo $value; ?>" readonly>
                        <hr>
                        <input type="button" name="<?php echo $name; ?>-upload-btn" id="<?php echo $id; ?>-upload-btn"
                               class="button-secondary upload-btn" value="Upload Image" style="margin-top: 15px;">
                        <input type="button" name="<?php echo $name; ?>-remove-btn" id="<?php echo $id; ?>-remove-btn"
                               class="button-secondary remove-upload-btn" value="Remove"
                               style="margin-top: 15px;<?php if (!$value) echo ' display: none;' ?>">
                        <div class="upload-image"><?php if ($value) echo '<img src="' . $value . '" style="margin-top: 15px;border-radius: 5px"/>'; ?></div>
                        <?php
                        break;
                    case 'repeater' :
                        $value = $value?$value:array('1');
                        ?>
                        <?php if(isset($args['fields']) && count($args['fields'])): ?>
                            <div class="thenatives-post-content-list repeater-field-list">
                            <?php foreach ($value as $key => $item) : ?>
                                <div class="thenatives-<?php echo $name; ?>-item repeater-field-item" data-item="<?php echo $key; ?>">
                                    <div class="repeater-field-item-header">
                                        <h3 class="repeater-field-item-title">Item Content <span>#<?php echo ($key+1); ?></span></h3>
                                        <div class="repeater-field-item-button" data-type="<?php echo $name; ?>">
                                            <button type="button" class="repeater-field-add button-secondary">+</button>
                                            <button type="button" class="repeater-field-remove button-secondary">-</button>
                                            <button type="button" class="repeater-field-open button-secondary"></button>
                                        </div>
                                    </div>
                                    <div class="repeater-field-item-content">
                                        <?php
                                        foreach ($args['fields'] as $j=>$field) {
                                            $fieldname = "{$name}[{$key}][{$field['name']}]";
                                            $field['id'] = "{$name}-{$key}-{$field['name']}";
                                            $field['value'] = isset($item[$field['name']])?$item[$field['name']]:$field['value'];
                                            $field['name'] = $fieldname;
                                            the_metabox_field($field);
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <div class="repeater-button-add" style="text-align: right">
                                <input type="hidden" name="<?php echo $name; ?>-args" id="<?php echo $id; ?>-args" class="repeater-args" value="<?php echo htmlspecialchars(json_encode($args)); ?>">
                                <button type="button" class="repeater-field-add button-secondary" style="margin-top: 10px;">Add Item</button>
                            </div>
                        <?php endif; ?>
                        <?php
                        break;
                    default :
                        ?>
                        <input type="text" name="<?php echo $name; ?>" class="thenatives-post-field-input"
                               id="<?php echo $id; ?>" value="<?php if ($value) echo $value; ?>">
                        <?php
                        break;
                }
                ?>
            </div>
        </div>
        <?php
    }
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}

function the_metabox_field($args){
    echo get_metabox_field($args);
}

add_action( 'wp_ajax_nopriv_repeater_field_add', 'repeater_field_add' );
add_action( 'wp_ajax_repeater_field_add', 'repeater_field_add' );
function repeater_field_add() {
    $args = str_replace('\"','"',$_POST['args']);
    $args = (array) json_decode($args);
    $name = (isset($args['name']) && $args['name'])?$args['name']:'';
    $key = $_POST['key'];
    ?>
    <div class="thenatives-<?php echo $name; ?>-item repeater-field-item" data-item="<?php echo $key; ?>">
        <div class="repeater-field-item-header">
            <h3 class="repeater-field-item-title">Item Content <span>#<?php echo ($key+1); ?></span></h3>
            <div class="repeater-field-item-button" data-type="<?php echo $name; ?>">
                <button type="button" class="repeater-field-add button-secondary">+</button>
                <button type="button" class="repeater-field-remove button-secondary">-</button>
                <button type="button" class="repeater-field-open button-secondary"></button>
            </div>
        </div>
        <div class="repeater-field-item-content">
            <?php
            foreach ($args['fields'] as $field) {
                $field = (array) $field;
                $fieldname = "{$name}[{$key}][{$field['name']}]";
                $field['id'] = "{$name}-{$key}-{$field['name']}";
                $field['name'] = $fieldname;
                the_metabox_field($field);
            }
            ?>
        </div>
    </div>
    <?php
    die();
}

function get_field($key,$id=NULL){
    $display = true;
    $id = $id?$id:get_the_ID();
    if(get_post_meta( $id, $key, $display )) {
        if(is_array(get_post_meta( $id, $key, $display ))){
            return get_post_meta($id, $key, $display);
        }
        return html_entity_decode(get_post_meta($id, $key, $display));
    }
    return '';
}

function the_field($key, $id=NULL){
    echo get_field($key,$id);
}

function have_rows($key, $id=NULL) {
    global $field,$rows;
    if(is_array(get_field($key,$id))) {
        if ($field != $key) {
            $field = $key;
            $rows = get_field($key,$id);
            return true;
        }
        if(count($rows)) {
            return true;
        }
        return false;
    }
    return false;
}

function the_row() {
    global $rows,$row;
    foreach ($rows as $key=>$item){
        $row = $key;
        unset($rows[$key]);
        break;
    }
}

function get_sub_field($key,$id=NULL) {
    global $field,$row;
    $fields = get_field($field,$id);
    $item = $fields[$row];
    if(isset($item[$key])){
        return $item[$key];
    }
    return '';
}

function the_sub_field($key,$id=NULL) {
    echo get_sub_field($key,$id);
}