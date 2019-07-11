<?php
$args = array(
    'role' => 'customer',
    'orderby' => 'display_name',
    'order' => 'ASC'
);
$customers = get_users($args);
?>
<h1>Stock SMS | Customer List</h1>
<table class="wp-list-table widefat fixed striped posts" id="customer_list">
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