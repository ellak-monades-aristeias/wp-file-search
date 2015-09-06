<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://tessera.gr
 * @since      1.0.0
 *
 * @package    Wp_File_Search
 * @subpackage Wp_File_Search/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
//must check that the user has the required capability 
if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
}

// Get an array of options from the database.
$options = get_option(self::OPTIONS_KEY);

if (isset($_POST['submit'])) {

    $options[self::OPT_DIRECT_PARSING] = isset($_POST[self::OPT_DIRECT_PARSING]);
    $options[self::OPT_FILE_TYPES] = $_POST[self::OPT_FILE_TYPES];
    $options[self::OPT_SEARCH_TYPE] = esc_html($_POST[self::OPT_SEARCH_TYPE]);

    //update array with options
    update_option(self::OPTIONS_KEY, $options);
    ?>
    <div class="updated"><p><strong><?php  _e('Settings saved.', 'search_on_files'); ?></strong></p></div>
    <?php
}
// header
echo "<h2>" . __('WP File Search Settings', 'search_on_files') . "</h2>";
?>
<!--settings form-->
<hr />
<form name="search_files_setting_form" method="post" action="">
    <!--Έλεγχος αρχείων-->
    <h3><?php  _e('Checking files', 'search_on_files'); ?></h3>
    <span class="notes">
        ***
        <?php
        _e('By selecting Direct file parsing, each file is being parsed during at uploading time. Otherwse all files are checked and parsed in an time interval of 3 hours.  It is recommended NOT to check the direct file parsing. ', 'search_on_files');
        ?></span> <br/> <br/>
    <input id="directChk" name="<?php echo self::OPT_DIRECT_PARSING; ?>" type="checkbox" <?php checked($options[self::OPT_DIRECT_PARSING], TRUE); ?> value='direct_parsing' />
    <label for="directChk"><?php _e('Direct file parsing', 'search_on_files'); ?></label><br/>

    <!--Τύποι αρχείων-->
    <h3><?php _e('File format', 'search_on_files'); ?></h3>
    <span class="notes">***
        <?php _e('Select the file formats that will be searchable', 'search_on_files'); ?>
    </span><br><br>
    <input id="pdfChk" name="<?php echo self::OPT_FILE_TYPES; ?>[]" type="checkbox" <?php if (in_array('pdf', $options[self::OPT_FILE_TYPES])):?>checked<?php endif; ?> value='pdf' />
    <label for="pdfChk">PDF</label><br/>
    <input id="docxChk" name="<?php echo self::OPT_FILE_TYPES; ?>[]" type="checkbox" <?php if (in_array('docx', $options[self::OPT_FILE_TYPES])):?>checked<?php endif; ?> value='docx' />
    <label for="docxChk">DOCX</label><br/>
    <input id="odtChk" name="<?php echo self::OPT_FILE_TYPES; ?>[]" type="checkbox" <?php if (in_array('odt', $options[self::OPT_FILE_TYPES])):?>checked<?php endif; ?> value='odt' />
    <label for="odtChk">ODT</label><br/>

    <!--Αναζήτηση Αρχείων-->
    <h3><?php _e('File search', 'search_on_files'); ?></h3>
    <span class="notes">
        ***
        <?php _e('Search on all files or only on attached files', 'search_on_files'); ?></span><br><br>
    <input id="allChk" type="radio" name="<?php echo self::OPT_SEARCH_TYPE; ?>" value="all" <?php checked('all', $options[self::OPT_SEARCH_TYPE]); ?> />
    <label for="allChk"><span style="margin-right: 8px;"><?php _e('Search on all files (Files will be appeared on search results)', 'search_on_files'); ?></span></label>
    <br>
    <input id="attachedChk" type="radio" name="<?php echo self::OPT_SEARCH_TYPE; ?>" value="attached" <?php checked('attached', $options[self::OPT_SEARCH_TYPE]); ?> />
    <label for="attachedChk"><?php _e('Search only the files that have been attached to an article or a page (The corresponding articles/pages will be appeared on search results)', 'search_on_files'); ?></label>

    <p>
        <input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
    </p>
</form>

