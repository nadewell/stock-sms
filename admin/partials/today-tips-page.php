<?php
//Database global variables
global $wpdb;
$tips_table = $wpdb->prefix."tips";
$tips = $wpdb->get_results( "SELECT * FROM $tips_table", OBJECT );
?>
<div class="wrap">
    <h1 class="wp-heading-inline">Today's Tips</h1>
    <?php 
        $current_user = wp_get_current_user();
        if( in_array( 'administrator',$current_user->roles ) ):
    ?>
    <a href="<?php echo admin_url('admin.php?page=tip-new'); ?>" class="page-title-action">Add New</a>
    <?php 
        endif; 
    ?>
    <hr/>
    <table class="wp-list-table widefat fixed striped"  id="tips_list">
        <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column">No.</td>
                <th scope="col" class="manage-column column-primary">Stock Name</th>
                <th scope="col" class="manage-column">Qty.</th>
                <th scope="col" class="manage-column">Entry Point</th>
                <th scope="col" class="manage-column">Entry Time</th>
                <th scope="col" class="manage-column">Exit Point</th>
                <th scope="col" class="manage-column">Exit Time</th>
                <th scope="col" class="manage-column">Result</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            foreach($tips as $tip):
            ?>
            <tr>
                <th scope="row" class="check-column"><?php echo $i; ?></th>
                <td class="column-title has-row-actions column-primary">
                    <strong><?php echo $tip->stock_name; ?></strong>
                    <button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
                </td>
                <td data-colname="Qty."><?php echo $tip->stock_qty; ?></td>
                <td data-colname="Entry Point"><?php echo $tip->entry_point; ?></td>
                <td data-colname="Entry Time"><?php echo $tip->entry_timestamp; ?></td>
                <td data-colname="Exit Time"><?php echo $tip->exit_point; ?></td>
                <td data-colname="Exit Time"><?php echo $tip->exit_timestamp; ?></td>
                <td data-colname="Result"><?php echo floatval( ( floatval($tip->stock_qty*$tip->exit_point)- floatval($tip->stock_qty*$tip->entry_point) ) ); ?></td>
            </tr>
            <?php
                $i++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>