<?php
$args = array(
    'role' => 'customer',
    'orderby' => 'display_name',
    'order' => 'ASC'
);
$customers = get_users($args);
?>
<div class="wrap">
    <h1>Stock SMS | Customer List</h1>
    <table class="wp-list-table widefat fixed striped" id="customer_list">
        <thead>
            <tr>
            <td id="cb" class="manage-column column-cb check-column">No.</td>
                <th scope="col" class="manage-column column-primary">Display Name</th>
                <th scope="col" class="manage-column">Username</th>
                <th scope="col" class="manage-column">Email</th>
                <th scope="col" class="manage-column">Password</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            foreach($customers as $customer):
            ?>
            <tr>
                <th scope="row" class="check-column"><?php echo $i; ?></th>
                <td class="column-title has-row-actions column-primary">
                    <strong><?php echo $customer->data->display_name; ?></strong>
                    <button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
                </td>
                <td data-colname="Username"><?php echo $customer->data->user_login; ?></td>
                <td data-colname="Email"><?php echo $customer->data->user_email; ?></td>
                <td data-colname="Password"><?php echo $customer->data->user_pass; ?></td>
            </tr>
            <?php
                $i++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>