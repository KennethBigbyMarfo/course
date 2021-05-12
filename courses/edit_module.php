<?php
require_once('../classes/mysql.class.php');

$security = new MySQL();
$security->checkLogin();

$sub1 = "list_module";

$navSecurity = new MySQL();
$navSecurity->checkNavigation($sub1);

if(isset($_GET['id']) && !empty($_GET['id'])){

    $cid = base64_decode($_GET['id']);

}else{

    header('Location:list_modules.php');

}

$selection = new MySQL();
$selection->Query("SELECT * FROM gs_courses WHERE id = $cid");
$record = $selection->Row();

$progs = new MySQL();
$progs->Query("SELECT gs_programs.id,gs_programs.name,gs_programs.code,partner_institutions.institution_name FROM gs_programs
LEFT JOIN partner_institutions ON gs_programs.partner_inst_id = partner_institutions.id  ORDER BY gs_programs.name");


?>

<!DOCTYPE html>
<html>
<head>
	<title>TERM - EDIT MODULE</title>
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
                                      <td colspan="4" style="text-align: center;"><h5><strong>Edit Module</strong></h5></td>
                                  </tr>
                                <tr>
                                   <td align="right">Program:</td>
                                  <td><select style="width: 300px;" name="progs" id="progs" class="form-control">
                                          <option disabled selected>--SELECT PROGRAM--</option>
                                          <?php while(!$progs->EndOfSeek()){ $prow = $progs->Row();?>
                                          <option  value="<?php echo $prow->code;?>" <?php if(is_object($record)){if($record->programs_code==$prow->code){ echo "selected";}}?>><?php echo $prow->name.' ('.$prow->institution_name.')';?></option>
                                          <?php } ?>
                                  </select><div id="progerror"></div></td>
                                    <td nowrap align="right">Module Code:</td>
                                  <td><input style="width: 280px;" type="text" name="code" id="code" value="<?php if(is_object($record)){echo $record->code;}?>" size="32"><div id="codeerror"></div></td>
                                </tr>

                                <tr valign="baseline">
                                  <td nowrap align="right">Module Name:</td>
                                  <td><input style="width: 280px;" type="text" name="name" id="name" value="<?php if(is_object($record)){echo $record->name;}?>" size="32"><div id="nameerror"></div></td>
                                     <td nowrap align="right">Credit Hours:</td>
                                  <td><select name="credit" id="credit" class="form-control" style="width: 300px;">
                                          <option disabled selected>--SELECT CREDIT--</option>
                                          <?php for($i=1;$i<=60;$i++){?>
                                              <option value="<?php echo $i;?>" <?php if(is_object($record)){if($record->credit==$i){ echo "selected";}}?>><?php echo $i;?></option>
                                          <?php } ?>
                                  </select><div id="crediterror"></div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap align="right">Level:</td>
                                  <td><select name="level" id="level" class="form-control" style="width: 300px;">
                                          <option disabled selected>--SELECT LEVEL--</option>
                                          <option value="500" <?php if(is_object($record)){if($record->level=="500"){ echo "selected";}}?>>500</option>
                                          <option value="600" <?php if(is_object($record)){if($record->level=="600"){ echo "selected";}}?>>600</option>
                                      </select><div id="levelerror"></div></td>

                                  <td nowrap align="right">Semester:</td>
                                  <td><select name="semester" id="semester" class="form-control" style="width: 300px;">
                                          <option disabled selected>--SELECT SEMESTER--</option>
                                          <option value="1" <?php if(is_object($record)){if($record->semester==1){ echo "selected";}}?>>1</option>
                                          <option value="2" <?php if(is_object($record)){if($record->semester==2){ echo "selected";}}?>>2</option>
                                      </select><div id="semerror"></div></td>
                                </tr>
                           		<tr valign="baseline">
                                  <td nowrap align="right">Module Description:</td>
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
                                <input type="hidden" name="do" value="updateModule">
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

                    $("#codeerror").html('<p><small style="color:red;">Enter module code.</small><p/>');


                }
                if(cname.length == 0){

                    $("#nameerror").html('<p><small style="color:red;">Enter module name.</small><p/>');


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
                        url: "../classes/modules.php",
                        data: $form.serialize(),
                        success: function(e) {


                             if(e=="up_ok"){

                                $('#result').html("<br><div align='center'><span class='alert alert-success' style='text-align: center;'><i class='icon icon-ok-sign'></i> Module updated successfully</span></div><br>").hide().fadeIn(1000);
                                 $("#wait").css("display","none");
                                $("#save").removeAttr('disabled');
                                 $("#close").removeAttr('disabled');

                            }else if(e=="up_error"){

                                $('#result').html("<br><div align='center'><span class='alert alert-danger' style='text-align: center;'><i class='icon icon-remove-sign'></i> Module update failed</span></div><br>").hide().fadeIn(1000);
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
