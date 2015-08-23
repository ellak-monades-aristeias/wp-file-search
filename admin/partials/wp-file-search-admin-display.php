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

// Direct file control option
$opt_direct_file_control_name = "direct_file_control";
$opt_direct_file_control_chk_name = "direct_file_control_chk";

//read pdf option
$opt_read_pdf_name = "read_pdf";
$opt_read_pdf_chk_name = "read_pdf_chk";

//read docx option
$opt_read_docx_name = "read_docx";
$opt_read_docx_chk_name = "read_docx_chk";

//read odt option
$opt_read_odt_name = "read_odt";
$opt_read_odt_chk_name = "read_odt_chk";

//search files option
$opt_search_files_name = "search_files";
$opt_search_files_chk_name = "search_files_chk";

// Get an array of options from the database.
$options_name = 'search_on_files_options';
$options = get_option($options_name);


if (isset($_POST['submit'])) {
    // Read the posted value
    $direct_file_control_value = $_POST[$opt_direct_file_control_chk_name] ? $_POST[$opt_direct_file_control_chk_name] : '';
    $read_pdf_value = $_POST[$opt_read_pdf_chk_name] ? $_POST[$opt_read_pdf_chk_name] : '';
    $read_docx_value = $_POST[$opt_read_docx_chk_name] ? $_POST[$opt_read_docx_chk_name] : '';
    $read_odt_value = $_POST[$opt_read_odt_chk_name] ? $_POST[$opt_read_odt_chk_name] : '';
    $search_files_value = $_POST[$opt_search_files_chk_name] ? $_POST[$opt_search_files_chk_name] : '';

    //set the new values
    $options[$opt_direct_file_control_name] = esc_html($direct_file_control_value);
    $options[$opt_read_pdf_name] = esc_html($read_pdf_value);
    $options[$opt_read_docx_name] = esc_html($read_docx_value);
    $options[$opt_read_odt_name] = esc_html($read_odt_value);
    $options[$opt_search_files_name] = esc_html($search_files_value);

    //update array with options
    update_option($options_name, $options);
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
        ?></span> <br> <br>
    <input name="<?php echo $opt_direct_file_control_chk_name; ?>" type="checkbox" <?php checked($opt_direct_file_control_chk_name, $options[$opt_direct_file_control_name]); ?> value='<?php echo $opt_direct_file_control_chk_name ?>' />
    <?php echo __('Άμεσος έλεγχος προσθαφαίρεσης αρχείων', 'search_on_files'); ?><br>

    <!--Τύποι αρχείων-->
    <h3><?php echo __('Τύποι αρχείων', 'search_on_files'); ?></h3>
    <span class="notes">***
        <?php echo __('Επιλέξτε τους τύπους αρχείων στους οποίους θα γίνεται αναζήτηση', 'search_on_files'); ?>
    </span><br><br>
    <input name="<?php echo $opt_read_pdf_chk_name; ?>" type="checkbox" <?php checked($opt_read_pdf_chk_name, $options[$opt_read_pdf_name]); ?> value='<?php echo $opt_read_pdf_chk_name ?>' />
    PDF<br>
    <input name="<?php echo $opt_read_docx_chk_name; ?>" type="checkbox" <?php checked($opt_read_docx_chk_name, $options[$opt_read_docx_name]); ?> value='<?php echo $opt_read_docx_chk_name; ?>' />
    DOCX<br>
    <input name="<?php echo $opt_read_odt_chk_name; ?>" type="checkbox" <?php checked($opt_read_odt_chk_name, $options[$opt_read_odt_name]); ?> value='<?php echo $opt_read_odt_chk_name; ?>' />
    ODT<br>

    <!--Αναζήτηση Αρχείων-->
    <h3><?php echo __('Αναζήτηση αρχείων', 'search_on_files'); ?></h3>
    <span class="notes">
        ***
        <?php echo __('Επιλέξτε αν θα αναζητούνται όλα τα αρχεία ή μονο τα αυτά που είναι attached σε κάποιο άρθρο', 'search_on_files'); ?></span><br><br>
    <input type="radio" name="<?php echo $opt_search_files_chk_name; ?>" value="search_all_files" <?php checked('search_all_files', $options[$opt_search_files_name]); ?> /><span style="margin-right: 8px;"><?php echo __('Αναζήτηση σε όλα τα αρχεία (Εμφάνιση των αρχείων στην σελίδα αποτελεσμάτων)', 'search_on_files'); ?></span>
    <br>
    <input type="radio" name="<?php echo $opt_search_files_chk_name; ?>" value="search_only_attached_files" <?php checked('search_only_attached_files', $options[$opt_search_files_name]); ?> /><?php echo __('Αναζήτηση μόνο στα αρχεία που έχουμε επισυναφθεί σε κάποιο άρθρο η σελίδα (Εμφάνιση των άρθρων/σελίδων στην σελίδα αποτελεσμάτων)', 'search_on_files'); ?>     

    <p>
        <input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
    </p>
</form>

