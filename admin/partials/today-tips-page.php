<?php
//Database global variables
global $wpdb;
$tips_table = $wpdb->prefix."tips";
$tips = $wpdb->get_results( "SELECT * FROM $tips_table", OBJECT );
?>
<div class="wrap">
    <h1 class="wp-heading-inline">Stock SMS | Subscription List</h1>
    <a href="<?php echo admin_url('admin.php?page=tip-new'); ?>" class="page-title-action">Add New Tip</a>
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Display Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            foreach($customers as $customer):
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $customer->data->display_name; ?></td>
                <td><?php echo $customer->data->user_login; ?></td>
                <td><?php echo $customer->data->user_email; ?></td>
                <td><?php echo $customer->data->user_pass; ?></td>
            </tr>
            <?php
                $i++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>