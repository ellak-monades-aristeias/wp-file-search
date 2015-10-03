<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/ellak-monades-aristeias/wp-file-search
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
    <div class="updated"><p><strong><?php  _e('Settings saved.', 'wp-file-search'); ?></strong></p></div>
    <?php
}
// header
echo "<h2>" . __('WP File Search Settings', 'wp-file-search') . "</h2>";
?>
<!--settings form-->
<hr />
<form name="search_files_setting_form" method="post" action="">
    <!--Έλεγχος αρχείων-->
    <h3><?php  _e('Checking files', 'wp-file-search'); ?></h3>
    <span class="notes">
        ***
        <?php
         _e('By selecting Direct file parsing, each file is being parsed during at uploading time. Otherwse all files are checked and parsed in an time interval of 1 hour. It is recommended NOT to check the direct file parsing.', 'wp-file-search');
        //_e('By selecting Direct file parsing, each file is being parsed during at uploading time. Otherwse all files are checked and parsed in an time interval of 3 hours.  It is recommended NOT to check the direct file parsing.', 'wp-file-search');
        ?></span> <br/> <br/>
    <input name="<?php echo self::OPT_DIRECT_PARSING; ?>" type="checkbox" <?php checked($options[self::OPT_DIRECT_PARSING], TRUE); ?> value='direct_parsing' />
    <?php _e('Direct file parsing', 'wp-file-search'); ?><br>

    <!--Τύποι αρχείων-->
    <h3><?php _e('File format', 'wp-file-search'); ?></h3>
    <span class="notes">***
        <?php _e('Select the file formats that will be searchable', 'wp-file-search'); ?>
    </span><br><br>
    <input name="<?php echo self::OPT_FILE_TYPES; ?>[]" type="checkbox" <?php if (in_array('pdf', $options[self::OPT_FILE_TYPES])):?>checked<?php endif; ?> value='pdf' />
    PDF<br>
    <input name="<?php echo self::OPT_FILE_TYPES; ?>[]" type="checkbox" <?php if (in_array('docx', $options[self::OPT_FILE_TYPES])):?>checked<?php endif; ?> value='docx' />
    DOCX<br>
    <input name="<?php echo self::OPT_FILE_TYPES; ?>[]" type="checkbox" <?php if (in_array('odt', $options[self::OPT_FILE_TYPES])):?>checked<?php endif; ?> value='odt' />
    ODT<br>

    <!--Αναζήτηση Αρχείων-->
    <h3><?php _e('File search', 'wp-file-search'); ?></h3>
    <span class="notes">
        ***
        <?php _e('Search on all files or only on attached files', 'wp-file-search'); ?></span><br><br>
    <input type="radio" name="<?php echo self::OPT_SEARCH_TYPE; ?>" value="all" <?php checked('all', $options[self::OPT_SEARCH_TYPE]); ?> /><span style="margin-right: 8px;"><?php _e('Search on all files (Files will be appeared on search results)', 'wp-file-search'); ?></span>
    <br>
    <input type="radio" name="<?php echo self::OPT_SEARCH_TYPE; ?>" value="attached" <?php checked('attached', $options[self::OPT_SEARCH_TYPE]); ?> /><?php _e('Search only the files that have been attached to an article or a page (The corresponding articles/pages will be appeared on search results)', 'wp-file-search'); ?>     

    <p>
        <input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
    </p>
</form>

