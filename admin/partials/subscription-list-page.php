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
<h1>Stock SMS | Subscription List</h1>
<table class="wp-list-table widefat fixed striped posts">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Package</th>
            <th>Timeperiod</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 1;
        foreach($subscriptions as $subscription):
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $subscription->display_name; ?></td>
            <td><?php echo $subscription->user_email; ?></td>
            <td><?php echo $subscription->package_name; ?></td>
            <td><?php echo $subscription->subscription_timeperiod; ?></td>
            <td><?php echo $subscription->package_price; ?></td>
        </tr>
        <?php
            $i++;
        endforeach;
        ?>
    </tbody>
</table>