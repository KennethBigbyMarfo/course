<?php
require_once('../classes/mysql.class.php');

$security = new MySQL();
$security->checkLogin();

	$sub1 = "list_courses";

	$navSecurity = new MySQL();
	$navSecurity->checkNavigation($sub1);

$prog = new MySQL();
$prog->Query("SELECT * FROM programs ORDER BY name");



?>

<!DOCTYPE html>
<html>
<head>
	<title>TERM - COURSE LIST</title>
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
                        <table align="center" class="table">
                            <tr>
                                <td colspan="2"><h5><strong>List of Courses</strong></h5></td>
                                <td></td>
                            </tr>
                        </table>
                        <hr>
                        <form method="POST" action="" id="find_course_form">

                            <table style="width: 650px;" align="center" class="table table-striped table-bordered table-hover table-responsive">
                                <thead>

                                <tr>
                                    <th colspan="3" style="text-align: center;"><h5><strong>FILTER BY PROGRAM</strong></h5></th>
                                </tr>
                                </thead>
                                <tbody>


                                <tr>
                                    <td>
                                        <select class="form-control" id="program" name="program" style="height: 35px; width: 500px;">
                                            <option selected disabled>--SELECT PROGRAM--</option>
											<?php while(!$prog->EndOfSeek()){ $prow = $prog->Row(); ?>
                                            <option value="<?php echo $prow->code;?>"><?php echo $prow->name;?></option>
                                            <?php } ?>
                                        </select>
                                    </td>

                                    <td><input  type="submit" name="find" id="find" class="btn btn-primary" value="Search"></td>
                                </tr>

                                <input type="hidden" name="do" value="studentList">
                                </tbody>
                            </table>

                        </form>
                        <hr>
                        <div class="col-lg-12 col-md-6 col-sm-12" id="result"><br>


                        </div><br>

                        <div>
                            <p align="center" style="display: none; color: limegreen;" id="wait"><img src="../img/select2/spinner.gif" > Searching for courses. Please wait....</p>
                        </div>
                    </div>
                    <div class="modal fade" id="viewcourseinfo" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div id="printableArea">
                                    <div class="modal-header" style="text-align: center;">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <div><h5><strong><i class="icon icon-edit"></i> Course Details</strong></h5></div>

                                    </div>
                                    <div class="modal-body">
                                        <div id="d_result"></div>
                                        <div style="display:none; text-align: center; color: limegreen;" id="d_wait"><img src="../img/select2/spinner.gif" > Deleting course. Please wait....</div>

                                        <div id="record"></div>
                                    </div>
                                </div>

                            </div>

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
<script src="../js/checkTermUserSession.js"></script>



    <script type="text/javascript">



        $(document).on("click","#coursedetail",function(){
            var dropvalue = $(this).attr('name');

            $('#d_result').empty();
            $.ajax({
                type: "POST",
                url: "fetch_course_data.php",
                data: {cid : dropvalue
                },
                success:function(sdata) {

                    $('#record').html(sdata);



                }

            });
        });


        $(function () {

            var $btns = $("#find");
            $btns.click(function (e) {

                e.preventDefault();
                $('#result').empty();
                $("#wait").css("display","block");
                $("#find").attr("disabled", "disabled");

                $.ajax({
                    type: "POST",
                    url: "process_course_search.php",
                    data: $('#find_course_form').serialize(),
                    success: function(e) {


                        if(e=="zero"){

                            $("#wait").css("display","none");

                            $("#result").html("<br><div align='center'><span class='alert alert-danger' style='text-align: center'> No results found for this search.</span></div>");
                            $("#result").hide().fadeIn(2000);
                            $("#find").removeAttr('disabled')

                        }else{

                            $("#wait").css("display","none");
                            $('#result').html(e);
                            $("#find").removeAttr('disabled');

                        }



                    }
                });
                return false;

            });

        });


    </script>

</body>
</html>
