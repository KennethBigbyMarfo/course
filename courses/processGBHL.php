<?php
require_once('../classes/mysql.class.php');
$security = new MySQL();
$security->checkLogin();
if(isset($_POST['ac_year']) && isset($_POST['program'])) {
    $acy = $_POST['ac_year'];
    $pro = $_POST['program'];
}else{
    $acy = -1;
    $pro = -1;
}

$courseLogs = new MySQL;
$sql = "SELECT gb_header.id,gb_header.gb_years_id,gb_header.semester, gb_header.session, gb_header.status,
CONCAT(courses.`code`,' - ',courses.`name`) AS course, gb_header.credit AS credit,
CONCAT(staff_employee_pdetail.fname,staff_employee_pdetail.lname) AS lecturer, programs.`code` AS program, gb_header.level
FROM gb_header INNER JOIN courses ON gb_header.courseid = courses.id
INNER JOIN staff_employee_pdetail ON gb_header.lecturerid = staff_employee_pdetail.empID
INNER JOIN programs ON gb_header.program_code = programs.code COLLATE latin1_general_ci WHERE programs.`code` = '$pro'
AND gb_header.gb_years_id = '$acy'";

$courseLogs->Query($sql);
$courseLogs->MoveFirst();

while(!$courseLogs->EndOfSeek()){
    $row = $courseLogs->Row();

    if($row->level == 100 && $row->semester == 1){

        $lvl1001[] = array('id'=>$row->id,'program'=>$row->program, 'course'=>$row->course,'credit'=>$row->credit,'lecturer'=>$row->lecturer,'status'=>$row->status);
    }
    if($row->level == 100 && $row->semester == 2){

        $lvl1002[] = array('id'=>$row->id,'program'=>$row->program, 'course'=>$row->course,'credit'=>$row->credit,'lecturer'=>$row->lecturer,'status'=>$row->status);
    }

    if($row->level == 200 && $row->semester == 1){

        $lvl2001[] = array('id'=>$row->id,'program'=>$row->program, 'course'=>$row->course,'credit'=>$row->credit,'lecturer'=>$row->lecturer,'status'=>$row->status);
    }
    if($row->level == 200 && $row->semester == 2){

        $lvl2002[] = array('id'=>$row->id,'program'=>$row->program, 'course'=>$row->course,'credit'=>$row->credit,'lecturer'=>$row->lecturer,'status'=>$row->status);
    }

    if($row->level == 300 && $row->semester == 1){

        $lvl3001[] = array('id'=>$row->id,'program'=>$row->program, 'course'=>$row->course,'credit'=>$row->credit,'lecturer'=>$row->lecturer,'status'=>$row->status);
    }
    if($row->level == 300 && $row->semester == 2){

        $lvl3002[] = array('id'=>$row->id,'program'=>$row->program, 'course'=>$row->course,'credit'=>$row->credit,'lecturer'=>$row->lecturer,'status'=>$row->status);
    }

    if($row->level == 400 && $row->semester == 1){

        $lvl4001[] = array('id'=>$row->id,'program'=>$row->program, 'course'=>$row->course,'credit'=>$row->credit,'lecturer'=>$row->lecturer,'status'=>$row->status);
    }
    if($row->level == 400 && $row->semester == 2){

        $lvl4002[] = array('id'=>$row->id,'program'=>$row->program, 'course'=>$row->course,'credit'=>$row->credit,'lecturer'=>$row->lecturer,'status'=>$row->status);
    }
}
?>

<table class="table table-striped table-bordered table-hover table-responsive" id="example">
<?php if(!empty($lvl1001)){?>
    <thead>
    <tr>
        <td colspan="10"><div class="alert alert-info"><strong>Level 100 Semester 1</strong></div></td>
    </tr>
    <tr>
        <th><input name="check[]" type="checkbox" ></th>
        <th>Program</th>
        <th>Course</th>
        <th>Credit</th>
        <th>Lecturer</th>
        <th>Status</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($lvl1001 as $element){?>
        <tr>
            <td><input name="check[]" type="checkbox" value="<?php echo $element['id']; ?>"></td>
            <td><?php echo $element['program']; ?></td>
            <td nowrap><?php echo $element['course']; ?></td>
            <td><?php echo $element['credit']; ?></td>
            <td><?php echo $element['lecturer']; ?></td>
            <td><?php echo $element['status']; ?></td>
            <td nowrap>
                <div class="btn-group settings">
                    <button onClick="return false" class="btn glow dropdown-toggle">Options >></button>
                    <button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="../reg/score_sheet.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>" target="_blank">Score Sheet</a></li>                        
                    </ul></div></td>
        </tr>
    <?php } ?>
    <?php } ?>
    </tbody>
    <?php if(!empty($lvl1002)){?>
    <thead>
    <tr>
        <td colspan="10"><div class="alert alert-info"><strong>Level 100 Semester 2</strong></div></td>
    </tr>
    <tr>
        <th><input name="check[]" type="checkbox" ></th>
        <th>Program</th>
        <th>Course</th>
        <th>Credit</th>
        <th>Lecturer</th>
        <th>Status</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($lvl1002 as $element){?>
        <tr>
            <td><input name="check[]" type="checkbox" value="<?php echo $element['id']; ?>"></td>
            <td><?php echo $element['program']; ?></td>
            <td nowrap><?php echo $element['course']; ?></td>
            <td><?php echo $element['credit']; ?></td>
            <td><?php echo $element['lecturer']; ?></td>
            <td><?php echo $element['status']; ?></td>
            <td nowrap>
                <div class="btn-group settings">
                    <button onClick="return false" class="btn glow dropdown-toggle">Options >></button>
                    <button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="gb_main.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Upload Result</a></li>
                        <li><a href="score_sheet.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Score Sheet</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=open&destination=gb_header_list.php">Open</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=submitted&destination=gb_header_list.php">Submit</a></li>
                        <li><a href="del_course_ass.php?id=<?php echo base64_encode(trim($row->id)); ?>" onClick="return confirm('This action will delete this assignment and its associated results, Do you want to continue?')">Delete</a></li>
                    </ul></div></td>
        </tr>
    <?php } ?>
    <?php } ?>
    </tbody>
    <?php if(!empty($lvl2001)){?>
    <thead>
    <tr>
        <td colspan="10"><div class="alert alert-info"><strong>Level 200 Semester 1</strong></div></td>
    </tr>
    <tr>
        <th><input name="check[]" type="checkbox" ></th>
        <th>Program</th>
        <th>Course</th>
        <th>Credit</th>
        <th>Lecturer</th>
        <th>Status</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($lvl2001 as $element){?>
        <tr>
            <td><input name="check[]" type="checkbox" value="<?php echo $element['id']; ?>"></td>
            <td><?php echo $element['program']; ?></td>
            <td nowrap><?php echo $element['course']; ?></td>
            <td><?php echo $element['credit']; ?></td>
            <td><?php echo $element['lecturer']; ?></td>
            <td><?php echo $element['status']; ?></td>
            <td nowrap>
                <div class="btn-group settings">
                    <button onClick="return false" class="btn glow dropdown-toggle">Options >></button>
                    <button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="gb_main.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Upload Result</a></li>
                        <li><a href="score_sheet.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Score Sheet</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=open&destination=gb_header_list.php">Open</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=submitted&destination=gb_header_list.php">Submit</a></li>
                        <li><a href="del_course_ass.php?id=<?php echo base64_encode(trim($row->id)); ?>" onClick="return confirm('This action will delete this assignment and its associated results, Do you want to continue?')">Delete</a></li>
                    </ul></div></td>
        </tr>
    <?php } ?>
    <?php } ?>
    </tbody>
    <?php if(!empty($lvl2002)){?>
    <thead>
    <tr>
        <td colspan="10"><div class="alert alert-info"><strong>Level 200 Semester 2</strong></div></td>
    </tr>
    <tr>
        <th><input name="check[]" type="checkbox" ></th>
        <th>Program</th>
        <th>Course</th>
        <th>Credit</th>
        <th>Lecturer</th>
        <th>Status</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($lvl2002 as $element){?>
        <tr>
            <td><input name="check[]" type="checkbox" value="<?php echo $element['id']; ?>"></td>
            <td><?php echo $element['program']; ?></td>
            <td nowrap><?php echo $element['course']; ?></td>
            <td><?php echo $element['credit']; ?></td>
            <td><?php echo $element['lecturer']; ?></td>
            <td><?php echo $element['status']; ?></td>
            <td nowrap>
                <div class="btn-group settings">
                    <button onClick="return false" class="btn glow dropdown-toggle">Options >></button>
                    <button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="gb_main.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Upload Result</a></li>
                        <li><a href="score_sheet.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Score Sheet</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=open&destination=gb_header_list.php">Open</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=submitted&destination=gb_header_list.php">Submit</a></li>
                        <li><a href="del_course_ass.php?id=<?php echo base64_encode(trim($row->id)); ?>" onClick="return confirm('This action will delete this assignment and its associated results, Do you want to continue?')">Delete</a></li>
                    </ul></div></td>
        </tr>
    <?php } ?>
    <?php } ?>
    </tbody>
    <?php if(!empty($lvl3001)){?>
    <thead>
    <tr>
        <td colspan="10"><div class="alert alert-info"><strong>Level 300 Semester 1</strong></div></td>
    </tr>
    <tr>
        <th><input name="check[]" type="checkbox" ></th>
        <th>Program</th>
        <th>Course</th>
        <th>Credit</th>
        <th>Lecturer</th>
        <th>Status</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($lvl3001 as $element){?>
        <tr>
            <td><input name="check[]" type="checkbox" value="<?php echo $element['id']; ?>"></td>
            <td><?php echo $element['program']; ?></td>
            <td nowrap><?php echo $element['course']; ?></td>
            <td><?php echo $element['credit']; ?></td>
            <td><?php echo $element['lecturer']; ?></td>
            <td><?php echo $element['status']; ?></td>
            <td nowrap>
                <div class="btn-group settings">
                    <button onClick="return false" class="btn glow dropdown-toggle">Options >></button>
                    <button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="gb_main.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Upload Result</a></li>
                        <li><a href="score_sheet.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Score Sheet</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=open&destination=gb_header_list.php">Open</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=submitted&destination=gb_header_list.php">Submit</a></li>
                        <li><a href="del_course_ass.php?id=<?php echo base64_encode(trim($row->id)); ?>" onClick="return confirm('This action will delete this assignment and its associated results, Do you want to continue?')">Delete</a></li>
                    </ul></div></td>
        </tr>
    <?php } ?>
    <?php } ?>
    </tbody>
    <?php if(!empty($lvl3002)){?>
    <thead>
    <tr>
        <td colspan="10"><div class="alert alert-info"><strong>Level 300 Semester 2</strong></div></td>
    </tr>
    <tr>
        <th><input name="check[]" type="checkbox" ></th>
        <th>Program</th>
        <th>Course</th>
        <th>Credit</th>
        <th>Lecturer</th>
        <th>Status</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($lvl3002 as $element){?>
        <tr>
            <td><input name="check[]" type="checkbox" value="<?php echo $element['id']; ?>"></td>
            <td><?php echo $element['program']; ?></td>
            <td nowrap><?php echo $element['course']; ?></td>
            <td><?php echo $element['credit']; ?></td>
            <td><?php echo $element['lecturer']; ?></td>
            <td><?php echo $element['status']; ?></td>
            <td nowrap>
                <div class="btn-group settings">
                    <button onClick="return false" class="btn glow dropdown-toggle">Options >></button>
                    <button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="gb_main.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Upload Result</a></li>
                        <li><a href="score_sheet.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Score Sheet</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=open&destination=gb_header_list.php">Open</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=submitted&destination=gb_header_list.php">Submit</a></li>
                        <li><a href="del_course_ass.php?id=<?php echo base64_encode(trim($row->id)); ?>" onClick="return confirm('This action will delete this assignment and its associated results, Do you want to continue?')">Delete</a></li>
                    </ul></div></td>
        </tr>
    <?php } ?>
    <?php } ?>
    </tbody>
    <?php if(!empty($lvl4001)){?>
    <thead>
    <tr>
        <td colspan="10"><div class="alert alert-info"><strong>Level 400 Semester 1</strong></div></td>
    </tr>
    <tr>
        <th><input name="check[]" type="checkbox" ></th>
        <th>Program</th>
        <th>Course</th>
        <th>Credit</th>
        <th>Lecturer</th>
        <th>Status</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($lvl4001 as $element){?>
        <tr>
            <td><input name="check[]" type="checkbox" value="<?php echo $element['id']; ?>"></td>
            <td><?php echo $element['program']; ?></td>
            <td nowrap><?php echo $element['course']; ?></td>
            <td><?php echo $element['credit']; ?></td>
            <td><?php echo $element['lecturer']; ?></td>
            <td><?php echo $element['status']; ?></td>
            <td nowrap>
                <div class="btn-group settings">
                    <button onClick="return false" class="btn glow dropdown-toggle">Options >></button>
                    <button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="gb_main.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Upload Result</a></li>
                        <li><a href="score_sheet.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Score Sheet</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=open&destination=gb_header_list.php">Open</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=submitted&destination=gb_header_list.php">Submit</a></li>
                        <li><a href="del_course_ass.php?id=<?php echo base64_encode(trim($row->id)); ?>" onClick="return confirm('This action will delete this assignment and its associated results, Do you want to continue?')">Delete</a></li>
                    </ul></div></td>
        </tr>
    <?php } ?>
    <?php } ?>
    </tbody>
    <?php if(!empty($lvl4002)){?>
    <thead>
    <tr>
        <td colspan="10"><div class="alert alert-info"><strong>Level 400 Semester 2</strong></div></td>
    </tr>
    <tr>
        <th><input name="check[]" type="checkbox" ></th>
        <th>Program</th>
        <th>Course</th>
        <th>Credit</th>
        <th>Lecturer</th>
        <th>Status</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($lvl4002 as $element){?>
        <tr>
            <td><input name="check[]" type="checkbox" value="<?php echo $element['id']; ?>"></td>
            <td><?php echo $element['program']; ?></td>
            <td nowrap><?php echo $element['course']; ?></td>
            <td><?php echo $element['credit']; ?></td>
            <td><?php echo $element['lecturer']; ?></td>
            <td><?php echo $element['status']; ?></td>
            <td nowrap>
                <div class="btn-group settings">
                    <button onClick="return false" class="btn glow dropdown-toggle">Options >></button>
                    <button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="gb_main.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Upload Result</a></li>
                        <li><a href="score_sheet.php?gb_header_id=<?php echo base64_encode(trim($row->id)); ?>">Score Sheet</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=open&destination=gb_header_list.php">Open</a></li>
                        <li><a href="changestatus.php?id=<?php echo base64_encode(trim($row->id)); ?>&status=submitted&destination=gb_header_list.php">Submit</a></li>
                        <li><a href="del_course_ass.php?id=<?php echo base64_encode(trim($row->id)); ?>" onClick="return confirm('This action will delete this assignment and its associated results, Do you want to continue?')">Delete</a></li>
                    </ul></div></td>
        </tr>
    <?php } ?>
    <?php } ?>
    </tbody>
</table>