<?php
require_once('../classes/mysql.class.php');

$security = new MySQL();
$security->checkLogin();

if(isset($_GET['id'])){

    $cid = base64_decode($_GET['id']);

}else{

    header('Location:list_courses.php');

}

$selection = new MySQL();
$selection->Query("SELECT * FROM courses WHERE id = $cid");
$record = $selection->Row();

$progs = new MySQL();
$progs->Query("SELECT * FROM programs");


?>

<!DOCTYPE html>
<html>
<head>
	<title>TERM - CREATE COURSE</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <!-- bootstrap -->
    <link href="../css/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap/bootstrap-responsive.css" rel="stylesheet">
    <link href="../css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet">

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../css/layout.css">
    <link rel="stylesheet" type="text/css" href="../css/elements.css">
    <link rel="stylesheet" type="text/css" href="../css/icons.css">

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="../css/lib/font-awesome.css">
    <link href="../css/lib/bootstrap.datepicker.css" type="text/css" rel="stylesheet" />
    
    <!-- this page specific styles -->
    <link rel="stylesheet" href="../css/compiled/new-user.css" type="text/css" media="screen" />

    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <style>
	#frmAdmin select{height:30px;}
	</style>
</head>
<body>

    <!-- navbar -->
	<?php require_once('../nav.php'); ?>
    <!-- end navbar -->

    <!-- sidebar -->
	<?php require_once('../menu.php'); ?>
    <!-- end sidebar -->


	<!-- main container -->
<div class="content">

        <div class="container-fluid">
		
            <div id="pad-wrapper" class="new-user">

                <div class="row-fluid form-wrapper">
                    <!-- left column -->
                    <div class="span12">
                        <div class="span5" id="result"></div>
                        <div style="display:none; color: limegreen;" id="wait"><img src="../img/select2/spinner.gif" > Updating course. Please wait....</div>
                        <div class="container">
                            <!-- this is the body of the document -->
                            <form method="post" name="form1" id="frmAdmin" action="" class="form-wrapper">

                              <table align="center" class="table table-striped table-bordered">
                                  <tr>
                                      <td colspan="4" style="text-align: center;"><h5><strong>Edit Course</strong></h5></td>
                                  </tr>
                                <tr>
                                   <td align="right">Program:</td>
                                  <td><select style="width: 300px;" name="progs" id="progs" class="form-control">
                                          <option disabled selected>--SELECT PROGRAM--</option>
                                          <?php while(!$progs->EndOfSeek()){ $prow = $progs->Row();?>
                                          <option  value="<?php echo $prow->code;?>" <?php if(is_object($record)){if($record->programs_code==$prow->code){ echo "selected";}}?>><?php echo $prow->name;?></option>
                                          <?php } ?>
                                  </select><div id="progerror"></div></td>
                                    <td nowrap align="right">Course Code:</td>
                                  <td><input style="width: 280px;" type="text" name="code" id="code" value="<?php if(is_object($record)){echo $record->code;}?>" size="32"><div id="codeerror"></div></td>
                                </tr>

                                <tr valign="baseline">
                                  <td nowrap align="right">Course Name:</td>
                                  <td><input style="width: 280px;" type="text" name="name" id="name" value="<?php if(is_object($record)){echo $record->name;}?>" size="32"><div id="nameerror"></div></td>
                                     <td nowrap align="right">Credit Hours:</td>
                                  <td><select name="credit" id="credit" class="form-control" style="width: 300px;">
                                         <option disabled selected>--SELECT CREDIT--</option>
                                         <optgroup label="Coventry Credits">
                                              <option value="10" <?php if(is_object($record)){if($record->credit==10){ echo "selected";}}?>>10</option>
                                              <option value="20" <?php if(is_object($record)){if($record->credit==20){ echo "selected";}}?>>20</option>
                                              <option value="30" <?php if(is_object($record)){if($record->credit==30){ echo "selected";}}?>>30</option>
                                              <option value="40" <?php if(is_object($record)){if($record->credit==40){ echo "selected";}}?>>40</option>
                                              <option value="50" <?php if(is_object($record)){if($record->credit==50){ echo "selected";}}?>>50</option>
                                              <option value="60" <?php if(is_object($record)){if($record->credit==60){ echo "selected";}}?>>60</option>
                                              
                                          </optgroup>
                                          <optgroup label="Other Credits">
                                              <option value="1" <?php if(is_object($record)){if($record->credit==1){ echo "selected";}}?>>1</option>
                                          <option value="2" <?php if(is_object($record)){if($record->credit==2){ echo "selected";}}?>>2</option>
                                          <option value="3" <?php if(is_object($record)){if($record->credit==3){ echo "selected";}}?>>3</option>
                                          <option value="4" <?php if(is_object($record)){if($record->credit==4){ echo "selected";}}?>>4</option>
                                          <option value="5" <?php if(is_object($record)){if($record->credit==5){ echo "selected";}}?>>5</option>
                                          <option value="6" <?php if(is_object($record)){if($record->credit==6){ echo "selected";}}?>>6</option>
                                          </optgroup>
                                          
                                  </select><div id="crediterror"></div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap align="right">Level:</td>
                                  <td><select name="level" id="level" class="form-control" style="width: 300px;">
                                           <option disabled selected>--SELECT LEVEL--</option>
                                           <optgroup label="Other Diplomas">
                                          <option value="100" <?php if(is_object($record)){if($record->level==100){ echo "selected";}}?>>100</option>
                                          <option value="200" <?php if(is_object($record)){if($record->level==200){ echo "selected";}}?>>200</option>
                                          <option value="300" <?php if(is_object($record)){if($record->level==300){ echo "selected";}}?>>300</option>
                                          <option value="400" <?php if(is_object($record)){if($record->level==400){ echo "selected";}}?>>400</option>
                                          <option value="500" <?php if(is_object($record)){if($record->level==500){ echo "selected";}}?>>500</option>
                                          <option value="600" <?php if(is_object($record)){if($record->level==600){ echo "selected";}}?>>600</option>
                                          </optgroup>
                                          
                                          <optgroup label="Coventry Levels">
                                          <option value="4" <?php if(is_object($record)){if($record->level==4){ echo "selected";}}?>>4</option>
                                          <option value="5" <?php if(is_object($record)){if($record->level==5){ echo "selected";}}?>>5</option>
                                          <option value="6" <?php if(is_object($record)){if($record->level==6){ echo "selected";}}?>>6</option>
                                          </optgroup>
                                          
                                      </select><div id="levelerror"></div></td>

                                  <td nowrap align="right">Semester:</td>
                                  <td><select name="semester" id="semester" class="form-control" style="width: 300px;">
                                          <option disabled selected>--SELECT SEMESTER--</option>
                                          <option value="1" <?php if(is_object($record)){if($record->semester==1){ echo "selected";}}?>>1</option>
                                          <option value="2" <?php if(is_object($record)){if($record->semester==2){ echo "selected";}}?>>2</option>
                                      </select><div id="semerror"></div></td>
                                </tr>
                           		<tr valign="baseline">
                                  <td nowrap align="right">Course Description:</td>
                                  <td><textarea style="width: 280px;" name="desc" id="desc" class="form-control"><?php if(is_object($record)){echo $record->description;}?></textarea><div id="descerror"></div>
                                  </td>
                                      <td nowrap align="right">Status:</td>
                                  <td>
                                        <select class="form-control" name="status" id="status" style="width: 300px;">
                                            <option disabled selected>--SELECT STATUS--</option>
                                            <option value="Active" <?php if(is_object($record)){if(ucwords(strtolower($record->status))=="Active"){echo "selected";}}?>>active</option>
                                            <option value="Inactive" <?php if(is_object($record)){if(ucwords(strtolower($record->status))=="Inactive"){echo "selected";}}?>>inactive</option>
                                        </select><div id="staterror"></div>
                                    </td>
                                </tr>
                             


                                   <tr valign="baseline">
                                       <td></td>
                                  <td><input type="submit" id="save" value="Update" class="btn btn-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       <input type="submit" id="close" value="Close" class="btn btn-primary" onclick="window.close()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                </tr>
                              </table>
                                <input type="hidden" name="do" value="updateCourse">
                                <input type="hidden" name="upid" value="<?php echo $cid;?>">

                            </form>

                      </div>
                    </div>

                    <!-- side right column -->
                    <div class="span3 form-sidebar pull-right">

                    </div>
                </div>
            </div>
        </div>
</div>
    <!-- end main container -->


	<!-- scripts -->

<!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
<script src="../js/jquery-latest.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.datepicker.js"></script>
<script src="../js/theme.js"></script>

    <script type="text/javascript">

        //header update

        $(function () {


            var $buttons = $("#save");
            var $form = $("#frmAdmin");

            $buttons.click(function (e) {

                e.preventDefault();
                $("#result").empty();
                $("#progerror").empty();
                $("#codeerror").empty();
                $("#nameerror").empty();
                $("#crediterror").empty();
                $("#levelerror").empty();
                $("#semerror").empty();
                $("#descerror").empty();
                $("#staterror").empty();


                var progs = $.trim($("#progs").val());
                var ccode = $.trim($("#code").val());
                var cname = $.trim($("#name").val());
                var credit = $.trim($("#credit").val());
                var level = $.trim($("#level").val());
                var sem = $.trim($("#semester").val());
                var desc = $.trim($("#desc").val());
                var stat = $.trim($("#status").val());


                if(progs.length == 0){

                    $("#progerror").html('<p><small style="color:red;">No program selected.</small><p/>');


                }
                if(ccode.length == 0){

                    $("#codeerror").html('<p><small style="color:red;">Enter course code.</small><p/>');


                }
                if(cname.length == 0){

                    $("#nameerror").html('<p><small style="color:red;">Enter course name.</small><p/>');


                }
                if(credit.length == 0){

                    $("#crediterror").html('<p><small style="color:red;">No credit selected.</small><p/>');


                }
                if(level.length == 0){

                    $("#levelerror").html('<p><small style="color:red;">No level selected.</small><p/>');


                }
                if(sem.length == 0){

                    $("#semerror").html('<p><small style="color:red;">No semester selected.</small><p/>');

                }
                if(desc.length == 0){

                    $("#descerror").html('<p><small style="color:red;">Enter description.</small><p/>');


                }
                if(stat.length == 0){

                    $("#staterror").html('<p><small style="color:red;">No status selected.</small><p/>');


                }


                if(progs.length != 0 && ccode.length != 0 && cname.length != 0 && credit.length != 0 && level.length != 0 && sem.length != 0 && desc.length != 0 && stat.length != 0){

                    $("#save").attr("disabled", "disabled");
                    $("#close").attr("disabled", "disabled");
                    $("#wait").css("display","block");
                    $("html, body").animate({ scrollTop: 0 }, "slow");

                    $.ajax({
                        type: "POST",
                        url: "../classes/courses.php",
                        data: $form.serialize(),
                        success: function(e) {


                             if(e=="up_ok"){

                                $('#result').html("<br><div align='center'><span class='alert alert-success' style='text-align: center;'><i class='icon icon-ok-sign'></i> Course updated successfully</span></div><br>").hide().fadeIn(1000);
                                 $("#wait").css("display","none");
                                $("#save").removeAttr('disabled');
                                 $("#close").removeAttr('disabled');

                            }else if(e=="up_error"){

                                $('#result').html("<br><div align='center'><span class='alert alert-danger' style='text-align: center;'><i class='icon icon-remove-sign'></i> Course update failed</span></div><br>").hide().fadeIn(1000);
                                $("#wait").css("display","none");
                                $("#save").removeAttr('disabled');
                                 $("#close").removeAttr('disabled');

                            }

                        }
                    });
                    return false;
                }
            });
        });


    </script>

</body>
</html>
