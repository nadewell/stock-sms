<?php
//Database global variables
global $wpdb;
$subscription_table = $wpdb->prefix."subscription";
$package_table = $wpdb->prefix."package";
$user_table = $wpdb->prefix."users";
/********************
 * 
 * SQL Query for All joined table:-
 * 
 *  SELECT
 *       *
 *  FROM
 *      wp_subscription,
 *      wp_users,
 *      wp_package
 *  WHERE
 *      wp_subscription.subscription_id = wp_users.ID AND wp_subscription.package_id = wp_package.package_id
 * 
 */
$subscriptions = $wpdb->get_results( 
    "SELECT 
        * 
    FROM 
        $subscription_table,
        $user_table,
        $package_table 
    WHERE 
        $subscription_table.subscription_id=$user_table.ID AND $subscription_table.package_id=$package_table.package_id",
    OBJECT 
);
?>
<div class="wrap">
    <h1>Stock SMS | Subscription List</h1>
    <table class="wp-list-table widefat fixed striped" id="subscription_list">
        <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column">No.</td>
                <th scope="col" class="manage-column column-primary">Name</th>
                <th scope="col" class="manage-column">Email</th>
                <th scope="col" class="manage-column">Package</th>
                <th scope="col" class="manage-column">Timeperiod</th>
                <th scope="col" class="manage-column">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            foreach($subscriptions as $subscription):
            ?>
            <tr>
                <th scope="row" class="check-column"><?php echo $i; ?></th>
                <td class="column-title has-row-actions column-primary">
                    <strong><?php echo $subscription->display_name; ?></strong>
                    <button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
                </td>
                <td data-colname="Email"><?php echo $subscription->user_email; ?></td>
                <td data-colname="Package"><?php echo $subscription->package_name; ?></td>
                <td data-colname="Timeperiod"><?php echo $subscription->subscription_timeperiod; ?></td>
                <td data-colname="Price"><?php echo $subscription->package_price; ?></td>
            </tr>
            <?php
                $i++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>