<?php
require_once('../classes/mysql.class.php');
if(!isset($_SESSION['term_UserGroup'])){session_start();}
$userGroup = $_SESSION['term_UserGroup'];
$adminGroup = array("2","11","36");

if(isset($_POST['program'])) {

    $program = $_POST['program'];

    $courses = new MySQL;
    $sql = "SELECT programs.name as program,courses.id as id,courses.name as cname, courses.code as ccode,courses.credit as ccredit,
courses.level as level, courses.semester as semester FROM courses
LEFT JOIN programs ON courses.programs_code = programs.code WHERE courses.programs_code='$program' ORDER BY level,semester,ccode";

    $courses->Query($sql);
    $counting = $courses->RowCount();
    $courses->MoveFirst();

    if($counting == 0){

        echo "zero";exit;

    }


$currentlevel=0;
$currentsemester=0;
?>

<br><table class="table table-striped table-bordered table-hover table-responsive" id="example">
   <thead>
           
            <tr><th>N0.#</th>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credit Hours</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
        <tbody>
       
      <?php 
      $i=1;
      while(!$courses->EndOfSeek()){
            $row=$courses->Row();
          
     ?>
     <?php if($row->level !=$currentlevel){
        $currentlevel=$row->level;
     ?>
     <tr><td colspan="5"></td></tr>
      <tr>
                <td colspan="5"><div class="alert alert-info"><strong>
                     <?php echo "Level ". $row->level; ?>
                </strong></div></td>
            </tr>
     <?php } ?>
         <?php if($row->semester !=$currentsemester){
        
         $currentsemester=$row->semester;
         $i=1;
         ?>
      <tr>
        <td colspan="5"><div class=""><strong>
                     <?php echo "Semester ".$row->semester; ?>
                </strong></div></td>
            </tr>
     <?php } ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo ucwords($row->ccode); ?></td>
                <td><?php echo ucwords($row->cname); ?></td>
                <td><?php echo $row->ccredit; ?></td>
                <td>
				<a href="#viewcourseinfo" data-toggle="modal" id="coursedetail" name="<?php echo $row->id;?>">Details</a> | 
				<?php if(in_array($userGroup,$adminGroup)){ ?>
				<a target="_blank" href="edit_courses.php?id=<?php echo base64_encode($row->id)?>">Edit</a></td>
				<?php } ?>
            </tr>
     <?php } ?>
        </tbody>

</table>

<?php } ?>