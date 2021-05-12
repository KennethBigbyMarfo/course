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
$selection->Query("SELECT * FROM programs WHERE id = $cid");
$record = $selection->Row();
$progs = new MySQL();
$progs->Query("SELECT * FROM departments where isacademic=1 order by name desc");
$security->Query("SELECT * FROM partner_institutions WHERE  LOWER(status) = 'active' order by institution_name");

?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>TERM - EDIT PROGRAMME</title>
    
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
                        <div style="display:none; color: limegreen;" id="wait"><img src="../img/select2/spinner.gif" > Updating programme. Please wait....</div>
                        <div class="container">
                            <!-- this is the body of the document -->
                            <form method="post" name="form1" id="frmAdmin" action="" class="form-wrapper">

                              <table align="center" class="table table-striped table-bordered">
                                  <tr>
                                      <td colspan="4" style="text-align: center;"><h5><strong>Edit Programme</strong></h5></td>
                                  </tr>
                                <tr>
                                   <td align="right">Department:</td>
                                  <td><select style="width: 300px;" name="department" id="department" class="form-control">
                                          <option disabled selected>--SELECT DEPARTMENT--</option>
                                          <?php while(!$progs->EndOfSeek()){ $prow = $progs->Row();?>
                                          <option  value="<?php echo $prow->id;?>" <?php if(is_object($record)){if($record->departments_id==$prow->id){ echo "selected";}}?>><?php echo $prow->name;?></option>
                                          <?php } ?>
                                  </select><div id="progerror"></div></td>
                                    <td nowrap align="right">Programme Code:</td>
                                  <td><input style="width: 280px;" type="text" name="code" id="code" value="<?php if(is_object($record)){echo $record->code;}?>" size="32"><div id="codeerror"></div></td>
                                </tr>

                                <tr valign="baseline">
                                  <td nowrap align="right">Programme Name:</td>
                                  <td><input style="width: 280px;" type="text" name="name" id="name" value="<?php if(is_object($record)){echo $record->name;}?>" size="32"><div id="nameerror"></div></td>
                                    <td nowrap align="right">Index Start:</td>
                                    <td><input style="width: 280px;"  type="text" name="index_starts" value="<?php if(is_object($record)){echo $record->index_starts;}?>" id="index_starts"/> <div id="indexerror"></div></td>
                                </tr>
                                  <tr valign="baseline">
                                      <td nowrap align="right">Official Name:</td>
                                      <td><input style="width: 280px;"  type="text" value="<?php if(is_object($record)){echo $record->official_name;}?>" name="official_name" id="official_name" /> <div id="offNameerror"></div></td>
                                      <td nowrap align="right">Partner Name:</td>
                                      <td><select name="partners_id" id="partners_id" class="form-control" style="width: 300px;">
                                              <option disabled selected>--SELECT PARTNER--</option>
                                              <?php while(!$security->EndOfSeek()){ 
                                              $prow = $security->Row();?>
                                                  <option  value="<?php echo $prow->id;?>"<?php if(is_object($record)){if($record->partners_id == $prow->id){ echo "selected";}}?>><?php echo $prow->institution_name;?></option>
                                              <?php } ?>
                                          </select><div id="partnererror"></div></td>
                                </tr>
                           		<tr valign="baseline">
                                      <td nowrap align="right">Status:</td>
                                  <td>
                                        <select class="form-control" name="status" id="status" style="width: 300px;">
                                            <option disabled selected>--SELECT STATUS--</option>
                                            <option value="Active" <?php if(is_object($record)){if(ucwords(strtolower($record->status))=="Active"){echo "selected";}}?>>active</option>
                                            <option value="Inactive" <?php if(is_object($record)){if(ucwords(strtolower($record->status))=="Inactive"){echo "selected";}}?>>inactive</option>
                                        </select><div id="staterror"></div>
                                    </td>
                                    
                                    
                                     <td nowrap align="right">Level:</td>
                                  <td>
                                        <select class="form-control" name="status" id="status" style="width: 300px;" required >
                                            <option  value="">--- Select ---</option>
                                            <option value="3">Diploma</option>
                                            <option value="4">Degree</option>
                                            <option value="5">Masters</option>
                                            <option value="6">Masters</option>
                                        </select><div id="staterror"></div>
                                    </td>
                                    </tr>
                                    <tr><td></td>
                                    <td colspan="2"><input type="submit" id="save" value="Update" class="btn btn-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="submit" id="close" value="Close" class="btn btn-primary" onclick="window.close()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                              </table>
                                <input type="hidden" name="do" value="updateProgramme">
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
                $("#indexerror").empty();
                $("#offNameerror").empty();
                $("#partnererror").empty();
                $("#staterror").empty();


                var progs = $.trim($("#department").val());
                var ccode = $.trim($("#code").val());
                var cname = $.trim($("#name").val());
                var indexstart = $.trim($("#index_starts").val());
                var officialname = $.trim($("#official_name").val());
                var partner = $.trim($("#partners_id").val());
                var desc = $.trim($("#desc").val());
                var stat = $.trim($("#status").val());


                if(progs.length == 0){

                    $("#progerror").html('<p><small style="color:red;">No department selected.</small><p/>');
                    $("html, body").animate({ scrollTop: 0 }, "slow");

                }
                if(ccode.length == 0){

                    $("#codeerror").html('<p><small style="color:red;">Enter programme code.</small><p/>');
                    $("html, body").animate({ scrollTop: 0 }, "slow");

                }
                if(cname.length == 0){

                    $("#nameerror").html('<p><small style="color:red;">Enter programme name.</small><p/>');
                    $("html, body").animate({ scrollTop: 0 }, "slow");

                }
                if(indexstart.length == 0){

                    $("#indexerror").html('<p><small style="color:red;">Enter index start.</small><p/>');
                    $("html, body").animate({ scrollTop: 0 }, "slow");

                }
                if(officialname.length == 0){

                    $("#offNameerror").html('<p><small style="color:red;">Enter official name.</small><p/>');
                    $("html, body").animate({ scrollTop: 0 }, "slow");

                }
                if(partner.length == 0){

                    $("#partnererror").html('<p><small style="color:red;">No partner selected.</small><p/>');
                    $("html, body").animate({ scrollTop: 0 }, "slow");

                }
                if(stat.length == 0){

                    $("#staterror").html('<p><small style="color:red;">No status selected.</small><p/>');
                    $("html, body").animate({ scrollTop: 0 }, "slow");

                }


                if(progs.length != 0 && ccode.length != 0 && cname.length != 0 && indexstart.length != 0 && officialname.length != 0 && partner.length != 0  && stat.length != 0){

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

                                $('#result').html("<br><div align='center'><span class='alert alert-success' style='text-align: center;'><i class='icon icon-ok-sign'></i> Programme updated successfully</span></div><br>").hide().fadeIn(1000);
                                 $("#wait").css("display","none");
                                $("#save").removeAttr('disabled');
                                 $("#close").removeAttr('disabled');

                            }else if(e=="up_error"){

                                $('#result').html("<br><div align='center'><span class='alert alert-danger' style='text-align: center;'><i class='icon icon-remove-sign'></i> Programme update failed</span></div><br>").hide().fadeIn(1000);
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
