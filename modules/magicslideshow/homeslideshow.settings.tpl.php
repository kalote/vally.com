<?php
    $lang_codes = Db::getInstance()->ExecuteS('SELECT id_lang, iso_code, active FROM `'._DB_PREFIX_.'lang` ORDER BY `id_lang` ASC');
?>
<script type="text/javascript">
//<![CDATA[
function MultiSelector(list_target, max) {

    this.list_target = list_target;
    this.count = 0;
    this.id = 0;
    if( max ){
        this.max = max;
    } else {
        this.max = -1;
    };

    this.addElement = function(element) {

        // Make sure it's a file input element
        if(element.tagName == 'INPUT' && element.type == 'file'){

            element.id = 'image_file-'+this.id;

            // Element name -- what number am I?
            element.name = 'magicslideshow_image_files['+(this.id++)+']';

            // Add reference to this object
            element.multi_selector = this;

            // What to do when a file is selected
            element.onchange = function(){

                // New file input
                var new_element = document.createElement('input');
                new_element.type = 'file';

                // Add new element
                //this.parentNode.insertBefore(new_element, this);
                this.parentNode.insertBefore(new_element, this.nextSibling);

                // Apply 'update' to element
                this.multi_selector.addElement(new_element);

                // Update list
                this.multi_selector.addListRow(this);

                // Hide this: we can't use display:none because Safari doesn't like it
                this.style.position = 'absolute';
                this.style.left = '-1000px';

            };
            // If we've reached maximum number, disable input element
            if( this.max != -1 && this.count >= this.max ){
                element.disabled = true;
            };

            // File element counter
            this.count++;

            // Most recent element
            this.current_element = element;

        } else {
            // This can only be applied to file input elements!
            alert('Error: not a file input element');
        };

    };

    /* Add a new row to the list of files */
    this.addListRow = function(element) {

        //Title input
        var new_title = document.createElement('input');
        new_title.type = 'text';
        new_title.value = element.value.replace(/^.*?([^\\]*)$/g, "$1");
        new_title.name = 'magicslideshow_images_data['+element.id.replace('image_file-','')+'][title]';
        new_title.style.width = "142px";

        //Description textarea
        var new_description = document.createElement('textarea');
        new_description.name = 'magicslideshow_images_data['+element.id.replace('image_file-','')+'][description]';
        new_description.style.width = "142px";
        new_description.style.maxWidth = "142px";
        new_description.style.minWidth = "142px";

        //Link input
        var new_link = document.createElement('input');
        new_link.type = 'text';
        new_link.name = 'magicslideshow_images_data['+element.id.replace('image_file-','')+'][link]';
        new_link.style.width = "142px";

        var new_lang = document.createElement('select');
        new_lang.name = 'magicslideshow_images_data['+element.id.replace('image_file-','')+'][lang]';
        new_lang.style.width = "38px";
        var option = document.createElement('option');
        option.value = 0;
        option.selected = true;
        option.innerHTML = 'all';
        new_lang.appendChild(option);
        <?php foreach($lang_codes as $lang) { ?>
            option = document.createElement('option');
            option.value = <?php echo $lang['id_lang']; ?>;
            <?php if(!$lang['active']) { ?>;
            if(typeof(option.setAttribute) != 'undefined') {
                option.setAttribute('disabled', 'disabled');
            } else {
                option.disabled = 'disabled';
            }
            <?php } ?>
            option.innerHTML = '<?php echo $lang['iso_code']; ?>';
            new_lang.appendChild(option);
        <?php } ?>

        //Delete button
        var del_button = document.createElement('img');
        del_button.alt = '<?php echo $this->l('Delete'); ?>';
        del_button.title = '<?php echo $this->l('Delete'); ?>';
        del_button.src = '../img/admin/delete.gif';
        del_button.style.cursor = "pointer";
        del_button.element = element;

        //Delete function
        del_button.onclick= function() {

            // Remove element from form
            this.element.parentNode.removeChild(this.element);

            // Remove this row from the list
            this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);

            // Decrement counter
            this.element.multi_selector.count--;

            // Re-enable input element (if it's disabled)
            this.element.multi_selector.current_element.disabled = false;

            // Hide table if it has not rows
            if(this.element.multi_selector.count == 1) this.element.multi_selector.list_target.style.display = 'none';

            // Appease Safari
            //    without it Safari wants to reload the browser window
            //    which nixes your already queued uploads
            return false;
        };

        var tr = this.list_target.insertRow(this.count-1);

        var td = document.createElement('TD');
        var s = element.value.replace(/^.*?([^\\]*)$/g, "$1");
        if(s.length > 24){
            s = '...' + s.substr(s.length-24);
        }
        td.innerHTML = s;
        tr.appendChild(td);

        td = document.createElement('TD');
        td.style.textAlign = "center";
        td.style.verticalAlign = "top";
        td.appendChild(new_title);
        tr.appendChild(td);

        td = document.createElement('TD');
        td.style.textAlign = "center";
        td.style.verticalAlign = "top";
        td.appendChild(new_description);
        tr.appendChild(td);

        td = document.createElement('TD');
        td.style.textAlign = "center";
        td.style.verticalAlign = "top";
        td.appendChild(new_link);
        tr.appendChild(td);

        td = document.createElement('TD');
        td.style.textAlign = "center";
        td.style.verticalAlign = "middle";
        td.appendChild(new_lang);
        tr.appendChild(td);

        td = document.createElement('TD');
        td.style.textAlign = "center";
        td.appendChild(del_button);
        tr.appendChild(td);

        this.list_target.style.display = 'block';//'table';
    };

};

function deleteImage(imageId){
    if(parseInt($('#delete-'+imageId).val())) {
        $('#title-'+imageId).removeAttr("disabled");
        $('#description-'+imageId).removeAttr("disabled");
        $('#link-'+imageId).removeAttr("disabled");
        $('#enabled-'+imageId).removeAttr("disabled");
        $('#row-'+imageId).css("background-color", "#FFFFF0");
        $('#delete-'+imageId).val(0).prev().find('img').attr("src", "../img/admin/delete.gif").attr("alt", "<?php echo $this->l('Delete'); ?>").attr("title", "<?php echo $this->l('Delete'); ?>");
    } else {
        $('#title-'+imageId).attr("disabled", true);
        $('#description-'+imageId).attr("disabled", true);
        $('#link-'+imageId).attr("disabled", true);
        $('#enabled-'+imageId).attr("disabled", true);
        $('#row-'+imageId).css("background-color", "#EEEEE0");
        $('#delete-'+imageId).val(1).prev().find('img').attr("src", "../img/admin/add.gif").attr("alt", "<?php echo $this->l('Not delete'); ?>").attr("title", "<?php echo $this->l('Not delete'); ?>");
    }
}
function changeOrder(imageId, direction) {
    var currImageOrder = $('#order-'+imageId).val();
	var targetRowID, arrowPressed;
	var arrow = new Object();
    if(direction) {
		arrow.pressed = 'Down';
		arrow.notpressed = 'Up';
		targetRowID = $('#row-'+imageId).next().attr('id');
	} else {
		arrow.pressed = 'Up';
		arrow.notpressed = 'Down';
		targetRowID = $('#row-'+imageId).prev().attr('id');
	}
    var targetImageId = targetRowID.replace("row-","");
    var targetImageOrder = $('#order-'+targetImageId).val();

	$('#order-'+targetImageId).val(currImageOrder);
    $('#order-'+imageId).val(targetImageOrder);

    if($('#arrow'+arrow.pressed+'-'+targetImageId).css('display') == 'none') {
        $('#arrow'+arrow.pressed+'-'+targetImageId).css('display', 'inline');
        $('#arrow'+arrow.pressed+'-'+imageId).css('display', 'none');
    }

    if($('#arrow'+arrow.notpressed+'-'+imageId).css('display') == 'none') {
        $('#arrow'+arrow.notpressed+'-'+imageId).css('display', 'inline');
        $('#arrow'+arrow.notpressed+'-'+targetImageId).css('display', 'none');
    }

	if(direction) {
		$('#row-'+imageId).before($('#row-'+targetImageId));
	} else {
		$('#row-'+imageId).after($('#row-'+targetImageId));
	}
}
//]]>
</script>
<?php
    $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'magicslideshow_images` ORDER BY `order`';
    $result = Db::getInstance()->ExecuteS($sql);
    if(count($result) > 0) {
?>
<label style="float: none;"><?php echo $this->l('Slideshow images') ?></label>
<div style="margin: 10px 0 10px 0;">
<table id="magicslideshow_images" cellspacing="0" cellpadding="0" class="table">
<thead>
<tr>
    <th><?php echo $this->l('ID'); ?></th>
    <th><?php echo $this->l('Order'); ?></th>
    <th><?php echo $this->l('Image'); ?></th>
    <th><?php echo $this->l('Title'); ?></th>
    <th><?php echo $this->l('Description'); ?></th>
    <th><?php echo $this->l('Link'); ?></th>
    <th><?php echo $this->l('Lang'); ?></th>
    <th><?php echo $this->l('Status'); ?></th>
    <th><?php echo $this->l('Actions'); ?></th>
</tr>
</thead>
<tbody>
<?php
        foreach($result as $position => $row) {
?>
<tr id="row-<?php echo $row['id']; ?>">
    <td class="center"><?php echo $row['id']; ?></td>
    <td class="center">
        <a<?php echo ($position == 0 ? ' style="display: none;"' : '' ); ?> id="arrowUp-<?php echo $row['id']; ?>" href="#" onclick="changeOrder(<?php echo $row['id']; ?>, 0);return false;"><img src="../img/admin/up.gif" alt="<?php echo $this->l('Up'); ?>" title="<?php echo $this->l('Up'); ?>" /></a><br />
        <a<?php echo ($position == sizeof($result)-1 ? ' style="display: none;"' : ''); ?> id="arrowDown-<?php echo $row['id']; ?>" href="#" onclick="changeOrder(<?php echo $row['id']; ?>, 1);return false;"><img src="../img/admin/down.gif" alt="<?php echo $this->l('Down'); ?>" title="<?php echo $this->l('Down'); ?>" /></a>
        <input type="hidden" name="images-update-data[<?php echo $row['id']; ?>][order]" id="order-<?php echo $row['id']; ?>" value="<?php echo $row['order']; ?>" />
    </td>
    <td><img src="<?php echo _PS_IMG_.'magicslideshow/'.$row['name'].'-home'.$this->imageTypeSuffix.'.'.$row['ext']; ?>" alt="<?php echo $row['title']; ?>" title="<?php echo $row['title']; ?>" style="width: 60px; height: 60px;" /></td>
    <td style="vertical-align: top;"><input type="text" name="images-update-data[<?php echo $row['id']; ?>][title]" id="title-<?php echo $row['id']; ?>" value="<?php echo $row['title']; ?>" /></td>
    <td style="vertical-align: top;"><textarea name="images-update-data[<?php echo $row['id']; ?>][description]" id="description-<?php echo $row['id']; ?>" ><?php echo $row['description']; ?></textarea></td>
    <td style="vertical-align: top;"><input type="text" name="images-update-data[<?php echo $row['id']; ?>][link]" id="link-<?php echo $row['id']; ?>" value="<?php echo $row['link']; ?>" /></td>
    <td class="center">
        <select name="images-update-data[<?php echo $row['id']; ?>][lang]" id="lang-<?php echo $row['id']; ?>">
            <option value="0" <?php if(!$row['lang']) { ?>selected="selected"<?php } ?>>all</option>
            <?php foreach($lang_codes as $lang) { ?>
            <option value="<?php echo $lang['id_lang']; ?>" <?php if($row['lang'] == $lang['id_lang']) { ?>selected="selected" <?php } ?> <?php if(!$lang['active']) { ?>disabled="disabled" <?php } ?>><?php echo $lang['iso_code']; ?></option>
            <?php } ?>
        </select> 
    </td>
    <td class="center"><input type="checkbox" name="images-update-data[<?php echo $row['id']; ?>][enabled]" id="enabled-<?php echo $row['id']; ?>" value="<?php echo $row['enabled']; ?>" title="<?php echo intval($row['enabled'])?$this->l('Enabled'):$this->l('Disabled'); ?>" onchange="if(this.checked){this.value=1;this.title='<?php echo $this->l('Enabled'); ?>';} else {this.value=0;this.title='<?php echo $this->l('Disabled'); ?>';}" <?php echo intval($row['enabled'])?'checked="checked" ':''; ?> /></td>
    <td class="center">
        <a href="#" onclick="deleteImage(<?php echo $row['id']; ?>);return false;" ><img src="../img/admin/delete.gif" alt="<?php echo $this->l('Delete'); ?>" title="<?php echo $this->l('Delete'); ?>" /></a>
        <input type="hidden" name="images-update-data[<?php echo $row['id']; ?>][delete]" id="delete-<?php echo $row['id']; ?>" value="0" />
    </td>
</tr>
<?php
        }
?>
</tbody>
</table>
</div>
<!--
<input class="button" type="button" onclick="$('#magic_submit').val(this.value).click(); return false;" value="<?php echo $this->l('Save'); ?>" style="margin: 0 0 10px 0;" /><br />
-->
<?php
    }
?>
<label style="float: none;"><?php echo $this->l('Images to upload') ?></label>
<div style="margin: 10px 0 10px 0;">
<table id="magicslideshow_upload_list" cellspacing="0" cellpadding="0" class="table" style="display: none;">
<thead>
<tr>
    <th><?php echo $this->l('File name'); ?></th>
    <th><?php echo $this->l('Title'); ?></th>
    <th><?php echo $this->l('Description'); ?></th>
    <th><?php echo $this->l('Link'); ?></th>
    <th><?php echo $this->l('Lang'); ?></th>
    <th><?php echo $this->l('Actions'); ?></th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
<input type="file" id="magicslideshow_image_file" name="magicslideshow_image_files" style="margin: 0 0 10px 0;" />
<script type="text/javascript">
//<![CDATA[
    var ms = new MultiSelector(document.getElementById('magicslideshow_upload_list'),10);
    ms.addElement(document.getElementById('magicslideshow_image_file'));
//]]>
</script>
<br /><input class="button" type="button" onclick="$('#magic_submit').val(this.value).click(); return false;" value="<?php echo $this->l('Upload files'); ?>" style="margin: 10px 0 0 0;" />
<br /><br />
<label style="float: none;"><?php echo $this->l('Slideshow shortcodes') ?></label>
<div style="margin: 10px 0 10px 0;">
In order to show slideshow on any CMS page just insert slideshow shortcode <b>[magicslideshow]</b>.<br />
If you want to show slideshow with specific images only, please use shortcode <b>[magicslideshow id=1,2,5]</b> where 1, 2 and 5 are numbers of images from the ID column.
</div>
