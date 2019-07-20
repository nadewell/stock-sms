<?php
//Database global variables
global $wpdb;
$tips_table = $wpdb->prefix."tips";
$tips = $wpdb->get_results( 
    "SELECT 
        * 
    FROM 
        $tips_table",
    OBJECT  
);
?>
<div class="wrap">
    <h1 class="wp-heading-inline">Add New Tips</h1>
    <hr/>
    <h2>Entry Tip</h2>
    <form method="POST" id="entry_form">
        <table class="wp-list-table widefat fixed striped posts">
            <tbody>
                <tr>
                    <td>Stock Name</td>
                    <td><input type="text" name="stock_name" id="stock_name" value="<?php echo ( isset($_POST['stock_name']) )?($_POST['stock_name']):(""); ?>"/></td>
                </tr>
                <tr>
                    <td>Qty.</td>
                    <td><input type="number" name="stock_qty" id="stock_qty" value="<?php echo ( isset($_POST['stock_qty']) )?($_POST['stock_qty']):(""); ?>"/></td>
                </tr>
                <tr>
                    <td>Entry Point</td>
                    <td><input type="number" name="entry_point" id="entry_point" value="<?php echo ( isset($_POST['entry_point']) )?($_POST['entry_point']):(""); ?>"/></td> 
                </tr>
                <tr>
                    <td>Entry Time</td>
                    <td><input type="text" name="entry_time" id="entry_time" value="<?php date_default_timezone_set("Asia/Kolkata"); echo date("h:i a"); ?>" disabled/></td>
                </tr>
                <tr>
                    <td>Stop Loss</td>
                    <td><input type="text" name="stop_loss" id="stop_loss" value="<?php echo ( isset($_POST['stop_loss']) )?($_POST['stop_loss']):(""); ?>"/></td>
                </tr>
                <tr>
                    <td><input class="button button-primary" type="submit" name="submit_entry" id="submit_entry" value="Submit"></td>
                </tr>
            </tbody>
        </table>
    </form>
    <br/>
    <hr/>
    <h2>Exit Tip</h2>
    <form method="POST" id="exit_form">
        <table class="wp-list-table widefat fixed striped posts">
            <tbody>
                <tr>
                    <td>Stock Name</td>
                    <td>
                        <select name="tip_id" id="tip_id">
                            <option value="">Select</option>
                            <?php 
                                foreach( $tips as $tip ):
                            ?>
                            <option value="<?php echo $tip->tip_id; ?>" <?php echo ( isset($_POST['tip_id']) && $_POST['tip_id'] === $tip->tip_id )?("selected"):(""); ?>><?php echo $tip->stock_name; ?></option>
                            <?php
                                endforeach;
                            ?>
                            </select>
                    </td>
                </tr>
                <tr>
                    <td>Exit Point</td>
                    <td><input type="number" name="exit_point" id="exit_point" value="<?php echo ( isset($_POST['exit_point']) )?($_POST['exit_point']):(""); ?>"/></td> 
                </tr>
                <tr>
                    <td>Exit Time</td>
                    <td><input type="text" name="exit_time" id="exit_time" value="<?php date_default_timezone_set("Asia/Kolkata"); echo date("h:i a"); ?>" disabled></td>
                </tr>
                <tr>
                    <td><input class="button button-primary" type="submit" name="submit_exit" id="submit_exit" value="Submit"></td>
                </tr>
            </tbody>
        </table>
    </form>
    <br/>
    <hr/>
    <h2>Extra Tip</h2>
    <form method="POST" id="extra_form">
        <table class="wp-list-table widefat fixed striped posts">
            <tbody>
                <tr>
                    <td>Message</td>
                    <td><textarea name="extra_tip" id="extra_tip"><?php echo ( isset($_POST['extra_tip']) )?($_POST['extra_tip']):(""); ?></textarea></td> 
                </tr>
                <tr>
                    <td><input class="button button-primary" type="submit" name="submit_extra" id="submit_extra" value="Submit"></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>