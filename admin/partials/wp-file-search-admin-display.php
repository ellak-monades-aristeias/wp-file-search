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
    <div class="updated"><p><strong><?php echo __('Settings saved.', 'search_on_files'); ?></strong></p></div>
    <?php
}
// header
echo "<h2>" . __('WP File Search Settings', 'search_on_files') . "</h2>";
?>
<!--settings form-->
<hr />
<form name="search_files_setting_form" method="post" action="">
    <!--Έλεγχος αρχείων-->
    <h3><?php echo __('Έλεγχος αρχείων', 'search_on_files'); ?></h3>
    <span class="notes">
        ***
        <?php
        echo __('Με την επιλογή άμεσου ελέγχου προσθαφαίρεσης αρχείων,
                        η ανάγνωση ενός αρχείου γίνεται κατά την στιγμή μεταφόρτωσης του. 
                        Σε κάθε άλλη περίπτωση ο έλεγχος των αρχείων γίνεται κάθε 3 ώρες ώστε να αποφεύγονται αργοί χρόνοι απόκρισης. Η επιλογή άμεσου ελέγχου προσθαφαίρεσης αρχείων δεν συνιστάται. ', 'search_on_files');
        ?></span> <br/> <br/>
    <input name="<?php echo self::OPT_DIRECT_PARSING; ?>" type="checkbox" <?php checked($options[self::OPT_DIRECT_PARSING], TRUE); ?> value='direct_parsing' />
    <?php echo __('Άμεσος έλεγχος προσθαφαίρεσης αρχείων', 'search_on_files'); ?><br>

    <!--Τύποι αρχείων-->
    <h3><?php echo __('Τύποι αρχείων', 'search_on_files'); ?></h3>
    <span class="notes">***
        <?php echo __('Επιλέξτε τους τύπους αρχείων στους οποίους θα γίνεται αναζήτηση', 'search_on_files'); ?>
    </span><br><br>
    <input name="<?php echo self::OPT_FILE_TYPES; ?>[]" type="checkbox" <?php if (in_array('pdf', $options[self::OPT_FILE_TYPES])):?>checked<?php endif; ?> value='pdf' />
    PDF<br>
    <input name="<?php echo self::OPT_FILE_TYPES; ?>[]" type="checkbox" <?php if (in_array('docx', $options[self::OPT_FILE_TYPES])):?>checked<?php endif; ?> value='docx' />
    DOCX<br>
    <input name="<?php echo self::OPT_FILE_TYPES; ?>[]" type="checkbox" <?php if (in_array('odt', $options[self::OPT_FILE_TYPES])):?>checked<?php endif; ?> value='odt' />
    ODT<br>

    <!--Αναζήτηση Αρχείων-->
    <h3><?php echo __('Αναζήτηση αρχείων', 'search_on_files'); ?></h3>
    <span class="notes">
        ***
        <?php echo __('Επιλέξτε αν θα αναζητούνται όλα τα αρχεία ή μονο τα αυτά που είναι attached σε κάποιο άρθρο', 'search_on_files'); ?></span><br><br>
    <input type="radio" name="<?php echo self::OPT_SEARCH_TYPE; ?>" value="all" <?php checked('all', $options[self::OPT_SEARCH_TYPE]); ?> /><span style="margin-right: 8px;"><?php echo __('Αναζήτηση σε όλα τα αρχεία (Εμφάνιση των αρχείων στην σελίδα αποτελεσμάτων)', 'search_on_files'); ?></span>
    <br>
    <input type="radio" name="<?php echo self::OPT_SEARCH_TYPE; ?>" value="attached" <?php checked('attached', $options[self::OPT_SEARCH_TYPE]); ?> /><?php echo __('Αναζήτηση μόνο στα αρχεία που έχουμε επισυναφθεί σε κάποιο άρθρο η σελίδα (Εμφάνιση των άρθρων/σελίδων στην σελίδα αποτελεσμάτων)', 'search_on_files'); ?>     

    <p>
        <input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
    </p>
</form>

