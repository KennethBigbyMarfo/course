<?php
require_once('../classes/mysql.class.php');
if(!isset($_SESSION['term_UserGroup'])){session_start();}
$userGroup = $_SESSION['term_UserGroup'];
$adminGroup = array("2","11");

if(isset($_POST['program'])) {

    $program = $_POST['program'];

    $courses = new MySQL;
    $sql = "SELECT programs.id,programs.`code`,programs.name as program,departments.`name` FROM programs  INNER JOIN departments ON programs.departments_id = departments.id 
WHERE departments.id='$program' ORDER BY programs.`code`";
    $courses->Query($sql);
    $counting = $courses->RowCount();
    $courses->MoveFirst();

    if($counting == 0){

        echo "zero";exit;

    }

}else{

        header('Location:list_courses.php');
}

?>

<br><table class="table table-striped table-bordered table-hover table-responsive" id="example">

        <thead>
        <tr>
            <td colspan="4"><div class="alert alert-info"><strong>PROGRAMME LIST</strong></div></td>
        </tr>
        <tr>

            <th>Programme Code</th>
            <th>Programme Name</th>
            <th>Department</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php while (!$courses->EndOfSeek()){
            $row = $courses->Row();
            ?>
            <tr>
                <td><?php echo strtoupper($row->code); ?></td>
                <td><?php echo ucwords($row->program); ?></td>
                <td><?php echo $row->name; ?></td>
                <td>
				<a href="#viewcourseinfo" data-toggle="modal" id="coursedetail" name="<?php echo $row->id;?>">Details</a> |
				<?php if(in_array($userGroup,$adminGroup)){ ?>
				<a target="_blank" href="edit_programme.php?id=<?php echo base64_encode($row->id)?>">Edit</a></td>
				<?php } ?>
            </tr>
        <?php }?>
        </tbody>
</table>