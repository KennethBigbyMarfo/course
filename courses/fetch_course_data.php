<?php
require_once('../classes/mysql.class.php');

$find = new MySQL;



    if(!empty($_POST['cid'])){

        $id =  $_POST['cid'];

        $find->Query("SELECT * FROM courses WHERE id = $id ");
        $row = $find->Row();



    }


?>

<br><form action="" method="post" id="cdetForm">
<table class="table table-condensed table-responsive" >

    <tr>
        <td><strong>Course Name:</strong></td>
        <td colspan="3" style="color: blue"><strong><?php echo ucwords(strtolower($row->name)) ;?></strong></td>
    </tr>
    <tr>
        <td><strong>Program:</strong></td>
        <td style="color: purple"><?php echo $row->programs_code ;?></td>

        <td><strong>Course Code:</strong></td>
        <td style="color: purple"><?php echo $row->code ;?></td>

    </tr>
    <tr>
        <td><strong>Credit Hours:</strong></td>
        <td style="color: purple"><?php echo $row->credit ;?></td>

        <td><strong>Level:</strong></td>
        <td style="color: purple"><?php echo $row->level ;?></td>
    </tr>

    <tr>
        <td><strong>Semester:</strong></td>
        <td style="color: purple"><?php echo $row->semester ;?></td>

        <td><strong>Status:</strong></td>
        <td style="color: purple"><?php echo strtolower($row->status) ;?></td>

    </tr>
    <tr>
        <td style="text-align: center;" colspan="4"><br><input type="submit" name="delete" id="delete" value="Delete Course" class="btn btn-danger"></in></td>
    </tr>

<input type="hidden" name="do" value="deleteCourse">
    <input type="hidden" name="uid" value="<?php echo $row->id;?>">

</form></table>

<script type="text/javascript" charset="utf-8">
    $(function () {

        var $btns = $("#delete");
        $btns.click(function (e) {

            e.preventDefault();

            $("#d_result").empty();
            $("#d_wait").css("display","block");
            $("#delete").attr("disabled", "disabled");

            $.ajax({
                type: "POST",
                url: "../classes/courses.php",
                data: $('#cdetForm').serialize(),
                success: function(e) {


                    if(e=="ok"){

                        $("#d_wait").css("display","none");
                        $("#delete").removeAttr('disabled');

                        $('#d_result').html('<div align="center"><span class="alert alert-success"><i class="icon icon-ok-sign"></i> Course deleted successfully</span></div><br>');

                    }else if(e=="exists"){

                        $("#d_wait").css("display","none");
                        $("#delete").removeAttr('disabled');

                        $('#d_result').html('<div align="center"><span class="alert alert-danger"><i class="icon icon-remove-sign"></i> Course deletion failed. Course exists in the header table.</span></div><br>');

                    }else if(e=="fail"){

                        $("#d_wait").css("display","none");
                        $("#delete").removeAttr('disabled');

                        $('#d_result').html('<div align="center"><span class="alert alert-danger"><i class="icon icon-remove-sign"></i> Course deletion failed.</span></div><br>');

                    }


                }
            });
            return false;

        });

    });

</script>