<?php
require_once('../classes/mysql.class.php');

if(isset($_POST['program'])) {

    $program = $_POST['program'];

    $courses = new MySQL;
    $sql = "SELECT gs_programs.name as program,gs_courses.id as id,gs_courses.name as cname, gs_courses.code as ccode,gs_courses.credit as ccredit,
gs_courses.level as level, gs_courses.semester as semester FROM gs_courses
LEFT JOIN gs_programs ON gs_courses.programs_code = gs_programs.code WHERE gs_courses.programs_code='$program'";

    //echo $sql;exit;
    $courses->Query($sql);
    $counting = $courses->RowCount();
    $courses->MoveFirst();

    if($counting == 0){

        echo "zero";exit;

    }

    if($counting > 0){
        while(!$courses->EndOfSeek()){
            $row = $courses->Row();

            if($row->level == 500 && $row->semester == 1){

                $lvl5001[] = array('id'=>$row->id,'program'=>$row->program, 'cname'=>$row->cname, 'ccode'=>$row->ccode, 'ccredit'=>$row->ccredit);
            }
            if($row->level == 500 && $row->semester == 2){

                $lvl5002[] = array('id'=>$row->id,'program'=>$row->program, 'cname'=>$row->cname, 'ccode'=>$row->ccode, 'ccredit'=>$row->ccredit);
            }

            if($row->level == 600 && $row->semester == 1){

                $lvl6001[] = array('id'=>$row->id,'program'=>$row->program, 'cname'=>$row->cname, 'ccode'=>$row->ccode, 'ccredit'=>$row->ccredit);
            }
            if($row->level == 600 && $row->semester == 2){

                $lvl6002[] = array('id'=>$row->id,'program'=>$row->program, 'cname'=>$row->cname, 'ccode'=>$row->ccode, 'ccredit'=>$row->ccredit);
            }
        }
    }


}else{

        header('Location:list_courses.php');
}

?>

<br><table class="table table-striped table-bordered table-hover table-responsive" id="example">
    <?php if(!empty($lvl5001)){?>
        <thead>
        <tr>
            <td colspan="4"><div class="alert alert-info"><strong>Level 500 - Semester 1</strong></div></td>
        </tr>
        <tr>
            <th>Module Code</th>
            <th>Module Name</th>
            <th>Credit Hours</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($lvl5001 as $element){?>
            <tr>
                <td><?php echo strtoupper($element['ccode']); ?></td>
                <td><?php echo ucwords(strtolower($element['cname'])); ?></td>
                <td><?php echo $element['ccredit']; ?></td>
                <td><a href="#viewcourseinfo" data-toggle="modal" id="coursedetail" name="<?php echo $element['id'];?>">Details</a> | <a target="_blank" href="edit_module.php?id=<?php echo base64_encode($element['id'])?>">Edit</a></td>
            </tr>
        <?php } ?>
        </tbody>
    <?php } ?>
    <?php if(!empty($lvl5002)){?>
        <thead>
        <tr>
            <td colspan="4"><div class="alert alert-info"><strong>Level 500 Semester 2</strong></div></td>
        </tr>
        <tr>
        <tr>
            <th>Module Code</th>
            <th>Module Name</th>
            <th>Credit Hours</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($lvl5002 as $element){?>
            <tr>
                <td><?php echo strtoupper($element['ccode']); ?></td>
                <td><?php echo ucwords(strtolower($element['cname'])); ?></td>
                <td><?php echo $element['ccredit']; ?></td>
                <td><a href="#viewcourseinfo" data-toggle="modal" id="coursedetail" name="<?php echo $element['id'];?>">Details</a> | <a target="_blank" href="edit_module.php?id=<?php echo base64_encode($element['id'])?>">Edit</a></td>
            </tr>
        <?php } ?>
        </tbody>
    <?php } ?>
    <?php if(!empty($lvl6001)){?>
        <thead>
        <tr>
            <td colspan="4"><div class="alert alert-info"><strong>Level 600 Semester 1</strong></div></td>
        </tr>
        <tr>
            <th>Module Code</th>
            <th>Module Name</th>
            <th>Credit Hours</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($lvl6001 as $element){?>
            <tr>
                <td><?php echo strtoupper($element['ccode']); ?></td>
                <td><?php echo ucwords(strtolower($element['cname'])); ?></td>
                <td><?php echo $element['ccredit']; ?></td>
                <td><a href="#viewcourseinfo" data-toggle="modal" id="coursedetail" name="<?php echo $element['id'];?>">Details</a> | <a target="_blank" href="edit_module.php?id=<?php echo base64_encode($element['id'])?>">Edit</a></td>
            </tr>
        <?php } ?>
        </tbody>
    <?php } ?>
    <?php if(!empty($lvl6002)){?>
        <thead>
        <tr>
            <td colspan="4"><div class="alert alert-info"><strong>Level 600 Semester 2</strong></div></td>
        </tr>
        <tr>
            <th>Module Code</th>
            <th>Module Name</th>
            <th>Credit Hours</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($lvl6002 as $element){?>
            <tr>
                <td><?php echo strtoupper($element['ccode']); ?></td>
                <td><?php echo ucwords(strtolower($element['cname'])); ?></td>
                <td><?php echo $element['ccredit']; ?></td>
                <td><a href="#viewcourseinfo" data-toggle="modal" id="coursedetail" name="<?php echo $element['id'];?>">Details</a> | <a target="_blank" href="edit_module.php?id=<?php echo base64_encode($element['id'])?>">Edit</a></td>
            </tr>
        <?php } ?>
        </tbody>
    <?php } ?>
</table>