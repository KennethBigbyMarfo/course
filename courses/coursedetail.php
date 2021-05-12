<?php 
require("../classes/mysql.class.php");
if(isset($_POST['mv']) && !empty($_POST['mv'])){
	$sql=new MySQL();
	$id=base64_decode($_POST['mv']);
	$query="SELECT
		courses.id,
		courses.programs_code,
		courses.`code`,
		courses.`name`,
		courses.credit,
		courses.description,
		courses.`level`,
		courses.semester,
		courses.featured_image,
		courses.`status`,
		programs.`name` AS programname,
		departments.`name` AS departmentname
		FROM
		courses
		INNER JOIN programs ON courses.programs_code = programs.`code`
		INNER JOIN departments ON programs.departments_id = departments.id
		 where courses.id=$id";
	$sql->Query($query);
	
	if($sql->RowCount()>0){
		$row=$sql->Row();
	?>
		<table class="table table-bordered table-striped">
        <tr >
        <td colspan="4"><?php echo $row->departmentname; ?></td>
        </tr>
        <tr>
        <td colspan="2"><?php echo $row->programname; ?></td>
        <td colspan="2"><?php echo $row->name; ?></td>
        </tr>
        <tr>
        <td>Program Code:</td>
        <td><?php echo $row->programs_code; ?></td>
        <td>Course Code:</td>
        <td><?php echo $row->code; ?></td>
        </tr>
        <tr>
        <td>Level:</td>
        <td><?php echo $row->level; ?></td>
        <td>Semester:</td>
        <td><?php echo $row->semester; ?></td>
        </tr>
        <tr>
        <td>Credit:</td>
        <td><?php echo $row->credit; ?></td>
        <td>Status:</td>
        <td><?php echo $row->status; ?></td>
        </tr>
        <tr><td>Description</td>
        <td colspan="3"><?php echo $row->description; ?></td>
        </tr>
        
        </table>
		<?php }
	}

?>