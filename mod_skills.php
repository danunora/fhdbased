<?php
include("includes/session.php");
include("includes/checksession.php");
include("includes/checksessionadmin.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Skills</title>
<?php
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
include("includes/functions.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$actionstatus = "";

// <UPDATE>
//to do: need to check for duplicates...
if (isset($_POST['nacl'])){
 if ( $_POST['nacl'] == md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;")) ) {
	//authentication verified, continue.

        $skill_name = $db->escape($_POST['skill_name']);
        $skill_desc = $db->escape($_POST['skill_desc']);

	$db->query("UPDATE skills SET skill_name='$skill_name',skill_desc='$skill_desc' WHERE skill_id = $skill_id;");
    	$actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
    	<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    	Updated.
    	</div>";
 } // if
}
// </UPDATE>

$nacl = md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;"));
?>

<h4>Edit Type</h4>
<?php 
echo $actionstatus;
echo "<p><a href='fhd_settings.php'>Settings</a></p>";
?>

<?php if ($num > 0) { 
$site_types = $db->get_results("SELECT type_id,type,type_name,type_desc,type_email,type_location,type_phone from site_types where type_id = $type_id order by type_name;");
echo "<form action='' method='post' class='form-horizontal'>\n";
echo "<table class='$table_style_3' style='width: auto;'>\n<input type='hidden' name='nacl' value='$nacl'>\n<input type='hidden' name='type_id' value='$type_id'>\n";

foreach ( $site_types as $site_type )
{
$type_id = $site_type->type_id;
$type = $site_type->type;
$type_name = $site_type->type_name;
$type_desc = $site_type->type_desc;
$type_email = $site_type->type_email;
$type_location = $site_type->type_location;
$type_phone = $site_type->type_phone;
	if ($type <> 0) { 
	echo "<tr><td>Name</td><td><input type='text' name='type_name' value='$type_name'></td></tr>\n";
	echo "<tr><td>Description</td><td><textarea name='type_desc'>$type_desc</textarea></td></tr>\n";
	echo "<tr><td colspan='2'><input type='submit' value='add' class='btn btn-primary'></td></tr>\n";
	echo "</table>\n</form>\n";
	}

	if ($type == 0) { 
	echo "<tr><td>Name</td><td><input type='text' name='type_name' value='$type_name'></td></tr>\n";
	echo "<tr><td>Description</td><td><textarea name='type_desc'>$type_desc</textarea></td></tr>\n";
	echo "<tr><td>Email</td><td><input type='text' name='type_email' value='$type_email'></td></tr>\n";
	echo "<tr><td>Location</td><td><input type='text' name='type_location' value='$type_location'></td></tr>\n";
	echo "<tr><td>Phone</td><td><input type='text' name='type_phone' value='$type_phone'></td></tr>\n";
	echo "<tr><td colspan='2'><input type='submit' name='' value='update'></td></tr>\n";
	echo "</table>\n</form>\n";
	}
}
} 
?>
<h5><i class="fa fa-arrow-left"></i> <a href="fhd_settings_action.php?type=<?php echo $type;?>">Back to <?php echo show_type_name($type);?></a></h5>

<?php
if(isset($_SESSION['name'])){
	
	echo "<br /><p><strong>Login Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
