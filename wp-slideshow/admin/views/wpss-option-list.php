<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Options List
 * 
 * @package WP Slideshow
 * @since 1.0
 */
if (!class_exists('WP_List_Table')) {

    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Wpss_Options_List extends WP_List_Table {

    public $model;

    function __construct() {

        global $wpss_model, $page;

        //Set parent defaults
        parent::__construct(array(
            'singular' => 'option', //singular name of the listed records
            'plural' => 'options', //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ));

        $this->model = $wpss_model;
    }

    /**
     * Displaying Options List
     *
     * Does prepare the data for displaying the options in the table.
     * 
     * @package WP Option List Table
     * @since 1.0.0
     */
    function display_options() {

        //call function to retrive data from table
        $data = $this->model->wpss_get_all_option_data();

        $resultdata = array();

        if (!empty($data)) {

            foreach ($data as $key => $value) {

                $resultdata[$key]['ID'] = $key;
                $resultdata[$key]['name'] = $value['slider_title'];
                $resultdata[$key]['description'] = $value['slider_description'];
                $resultdata[$key]['image'] = isset($value['slider_image']) ? '<img src="' . $value['slider_image'] . '" height="50px" width="50px">' : '';
            }
        }

        return $resultdata;
    }

    /**
     * Mange column data
     *
     * Default Column for listing table
     * 
     * @package WP Option List Table
     * @since 1.0.0
     */
    function column_default($item, $column_name) {

        switch ($column_name) {
            case 'name':
            case 'description':
            case 'image':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Manage Edit/Delete Link
     * 
     * Does to show the edit and delete link below the column cell
     * function name should be column_{field name}
     * For ex. I want to put Edit/Delete link below the post title 
     * so i made its name is column_post_title
     * 
     * @package WP Option List Table
     * @since 1.0.0
     */
    function column_name($item) {

        //Build row actions
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&optid=%s">' . esc_html__('Edit', 'wpss') . '</a>', 'wpss-add-slider', 'edit', $item['ID']),
            'delete' => sprintf('<a href="?page=%s&action=%s&option[]=%s">' . esc_html__('Delete', 'wpss') . '</a>', $_REQUEST['page'], 'delete', $item['ID']),
        );

        //Return the title contents	        
        return sprintf('%1$s %2$s',
                /* $1%s */ $item['name'],
                /* $2%s */ $this->row_actions($actions)
        );
    }

    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />',
                /* $1%s */ $this->_args['singular'], //Let's simply repurpose the table's singular label ("movie")
                /* $2%s */ $item['ID']                //The value of the checkbox should be the record's id
        );
    }

    /**
     * Display Columns
     *
     * Handles which columns to show in table
     * 
     * @package WP Option List Table
     * @since 1.0.0
     */
    function get_columns() {

        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'name' => esc_html__('Title', 'wpss'),
            'description' => esc_html__('Description', 'wpss'),
            'image' => esc_html__('Image', 'wpss'),
        );
        return $columns;
    }

    function no_items() {

        //message to show when no records in database table
        esc_html_e('No Lists found.', 'wpss');
    }

    function process_bulk_action() {

        //Detect when a bulk action is being triggered...
        if ('delete' === $this->current_action()) {

            wp_die(esc_html__('Items deleted (or they would be if we had items to delete)!', 'wpss'));
        }
    }

    function prepare_items() {

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 10;

        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);

        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        /**
         * Instead of querying a database, we're going to fetch the example data
         * property we created for use in this plugin. This makes this example 
         * package slightly different than one you might build on your own. In 
         * this example, we'll be using array manipulation to sort and paginate 
         * our data. In a real-world implementation, you will probably want to 
         * use sort and pagination data to build a custom query instead, as you'll
         * be able to use your precisely-queried data immediately.
         */
        $data = $this->display_options();

        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();

        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);

        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data, (($current_page - 1) * $per_page), $per_page);

        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;

        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page, //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items / $per_page) //WE have to calculate the total number of pages
                )
        );
    }

}

//Create an instance of our package class...
$OptionListTable = new Wpss_Options_List();

//Fetch, prepare, sort, and filter our data...
$OptionListTable->prepare_items();

$manage_option_page = add_query_arg(array('page' => 'wpss-add-slider'), admin_url('admin.php'));
?>

<div class="wrap">
    <h2>
<?php esc_html_e('Slider Lists', 'wpss'); ?>
        <a class="add-new-h2" href="<?php echo $manage_option_page; ?>"><?php esc_html_e('Add New', 'wpss'); ?></a>
    </h2>
    <div class="updated sortableupdated" id="message" style="display: none;">
        <p><strong><?php echo esc_html__("Order Updated Successfully. Please wait....", 'wpss'); ?></strong></p>
    </div>
        <?php
        $html = '';
        if (isset($_GET['message']) && !empty($_GET['message'])) { //check message
            if ($_GET['message'] == '1') { //check insert message
                $html .= '<div class="updated settings-error" id="setting-error-settings_updated">
							<p><strong>' . esc_html__("Option Inserted Successfully.", 'wpss') . '</strong></p>
						</div>';
            } else if ($_GET['message'] == '2') {//check update message
                $html .= '<div class="updated" id="message">
							<p><strong>' . esc_html__("Option Updated Successfully.", 'wpss') . '</strong></p>
						</div>';
            } else if ($_GET['message'] == '3') {//check delete message
                $html .= '<div class="updated" id="message">
							<p><strong>' . esc_html__("Option deleted Successfully.", 'wpss') . '</strong></p>
						</div>';
            } else if ($_GET['message'] == '4') {//check delete message
                $html .= '<div class="updated" id="message">
							<p><strong>' . esc_html__("Status Changed Successfully.", 'wpss') . '</strong></p>
						</div>';
            }
        }
        echo $html;
        ?>
    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="option-filter" method="get">

        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />


        <!-- Now we can render the completed list table -->
<?php $OptionListTable->display(); ?>

    </form>

</div>