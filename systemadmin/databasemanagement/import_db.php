<!DOCTYPE html>
<?php require_once "../../resources/config.php"; ?>
<?php include ('include_files/session_check.php'); ?>
<?php
  $filename = $_GET['filename'];
  $filesize = $_GET['filesize'];
  $date = $_GET['date'];

  $_SESSION['file'] = $filename;
  $_SESSION['size'] = $filesize;
  $_SESSION['date'] = $date;

?>

<html>
    <head>
        <title>Add Personnel Account</title>
        <link rel="shortcut icon" href="../../assets/images/ico/fav.png" type="image/x-icon" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap -->
        <link href="../../resources/libraries/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="../../resources/libraries/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="../../resources/libraries/nprogress/nprogress.css" rel="stylesheet">
        <!-- Profile Picture -->
        <link rel="stylesheet" href="prof_pic/scripts/imgareaselect.css">
        <!-- Custom Theme Style -->
        <link href="../../assets/css/custom.min.css" rel="stylesheet">
        <link href="../../assets/css/tstheme/style.css" rel="stylesheet">
    </head>
    <body class="nav-md">
        <?php include "../../resources/templates/admin/sidebar.php"; ?>
        <?php include "../../resources/templates/admin/top-nav.php"; ?>
        <!-- Content Start -->
        <div class="right_col" role="main">
         <div class="col-md-5">
        <ol class="breadcrumb">
          <li><a href="../index.php">Home</a></li>
          <li class="disabled">Generate Backup</li>
          <li class="active">Import Backup</li>
        </ol>
      </div>
            <div class="row top_tiles"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                    <p><strong>Note:  <i class="fa fa-info-circle"></i> </strong> Importing a backup file will <strong>overwrite</strong> the current database.</p>
                    <h2><i class="fa fa-database"></i> Import Database <br> <br>
                      <strong>File name : </strong> <?php echo $filename ?><br><br>
                      <strong>File size : </strong> <?php echo $filesize ?><br><br>
                      <strong>Date created :</strong> <?php echo $date ?>
                    </h2> 
                        <div class="clearfix"></div>
                        <br>
                               <?php
                                  if (isset($_SESSION['db_msg_import_2'])) {
                                      echo $_SESSION['db_msg_import_2'];
                                      unset($_SESSION['db_msg_import_2']);
                                        }
                                  ?>
                            <div class="x_content">
          <form id="personnel-add" class="form-horizontal form-label-left" action = "phpscript/db_import.php" method="POST" data-parsley-trigger="keyup">

                                    <div class="item form-group"><br>
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Database Username</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="db_uname" type="text"  class="form-control"  required=""
                                                  data-parsley-minlength="4"
                                                  data-parsley-minlength-message="User Name should be greater than 4 characters"
                                                  data-parsley-maxlength="50"
                                                  data-parsley-maxlength-message="Error">
                                        </div>
                                    </div>

                                    <div class="item form-group"><br>
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Database Password</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="db_pw" type="password" class="form-control"  required="" 
                                                   data-parsley-minlength="4"
                                                   data-parsley-minlength-message="Password should be greater than 4 characters"
                                                   data-parsley-maxlength="50"
                                                   data-parsley-maxlength-message="Error">
                                        </div>
                                    </div>

                                    <div class="item form-group"><br>
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Account Password</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                         <input name="pw" type="password" class="form-control" required="" 
                                                    data-parsley-minlength="4"
                                                    data-parsley-minlength-message="Password should be greater than 4 characters"
                                                    data-parsley-maxlength="50"
                                                    data-parsley-maxlength-message="Error">
                                        </div>
                                    </div>

                                <div class="form-group">
                                    <br>
                                    <div class="col-md-5 col-md-offset-3 pull-left">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-inbox"></i> Import Database</button>
                                    </div>
                                </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- /page content -->
    <!-- /modals -->
    <!-- Footer -->
    <?php include "../../resources/templates/admin/footer.php"; ?>
    <!-- Scripts -->
    <!-- jQuery -->
    <script src="../../resources/libraries/jquery/dist/jquery.min.js" ></script>
    <!-- Bootstrap -->
    <script src="../../resources/libraries/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src= "../../resources/libraries/fastclick/lib/fastclick.js"></script>
    <!-- input mask -->
    <script src= "../../resources/libraries/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src= "../../resources/libraries/parsleyjs/dist/parsley.min.js"></script>
    <!-- NProgress -->
    <script src="../../resources/libraries/nprogress/nprogress.js"></script>
    <!-- Profile Picture -->
    <script src="prof_pic/scripts/jquery.imgareaselect.js" type="text/javascript"></script>
    <script src="prof_pic/scripts/jquery.form.js"></script>
    <!-- Custom Theme Scripts -->
    <script src= "../../assets/js/custom.min.js"></script>
    <!-- Parsley -->
    <script>
        $(document).ready(function() {
            $.listen('parsley:field:validate', function() {
                validateFront();
            });
            $('#personnel-add .btn').on('click', function() {
                $('#personnel-add').parsley().validate();
                validateFront();
            });
            var validateFront = function() {
                if (true === $('#personnel-add').parsley().isValid()) {
                    $('.bs-callout-info').removeClass('hidden');
                    $('.bs-callout-warning').addClass('hidden');
                } else {
                    $('.bs-callout-info').addClass('hidden');
                    $('.bs-callout-warning').removeClass('hidden');
                }
            };
        });
        try {
            hljs.initHighlightingOnLoad();
        } catch (err) {}
    </script>
    <!-- /Parsley -->
    <script type="text/javascript">
        jQuery(document).ready(function(){
        
        jQuery('#change-pic').on('click', function(e){
            jQuery('#changePic').show();
            jQuery('#change-pic').hide();
            
        });
        
        jQuery('#photoimg').on('change', function()   
        { 
            jQuery("#preview-avatar-profile").html('');
            jQuery("#preview-avatar-profile").html('Uploading....');
            jQuery("#cropimage").ajaxForm(
            {
            target: '#preview-avatar-profile',
            success:    function() { 
                    jQuery('img#photo').imgAreaSelect({
                    aspectRatio: '1:1',
                    onSelectEnd: getSizes,
                });
                jQuery('#image_name').val(jQuery('#photo').attr('file-name'));
                }
            }).submit();

        });
        
        jQuery('#btn-crop').on('click', function(e){
        e.preventDefault();
        params = {
                targetUrl: 'prof_pic/profile.php?action=save',
                action: 'save',
                x_axis: jQuery('#hdn-x1-axis').val(),
                y_axis : jQuery('#hdn-y1-axis').val(),
                x2_axis: jQuery('#hdn-x2-axis').val(),
                y2_axis : jQuery('#hdn-y2-axis').val(),
                thumb_width : jQuery('#hdn-thumb-width').val(),
                thumb_height:jQuery('#hdn-thumb-height').val()
            };

            saveCropImage(params);
        });
        
     
        
        function getSizes(img, obj)
        {
            var x_axis = obj.x1;
            var x2_axis = obj.x2;
            var y_axis = obj.y1;
            var y2_axis = obj.y2;
            var thumb_width = obj.width;
            var thumb_height = obj.height;
            if(thumb_width > 0)
                {

                    jQuery('#hdn-x1-axis').val(x_axis);
                    jQuery('#hdn-y1-axis').val(y_axis);
                    jQuery('#hdn-x2-axis').val(x2_axis);
                    jQuery('#hdn-y2-axis').val(y2_axis);
                    jQuery('#hdn-thumb-width').val(thumb_width);
                    jQuery('#hdn-thumb-height').val(thumb_height);
                    
                }
            else
                alert("Please select portion..!");
        }
        
        function saveCropImage(params) {
        jQuery.ajax({
            url: params['targetUrl'],
            cache: false,
            dataType: "html",
            data: {
                action: params['action'],
                id: jQuery('#hdn-profile-id').val(),
                 t: 'ajax',
                                    w1:params['thumb_width'],
                                    x1:params['x_axis'],
                                    h1:params['thumb_height'],
                                    y1:params['y_axis'],
                                    x2:params['x2_axis'],
                                    y2:params['y2_axis'],
                                    image_name :jQuery('#image_name').val()
            },
            type: 'Post',
           // async:false,
            success: function (response) {
                    jQuery('#changePic').hide();
                    jQuery('#change-pic').show();
                    jQuery(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');
                    
                    jQuery("#avatar-edit-img").attr('src', response);
                    jQuery("#preview-avatar-profile").html('');
                    jQuery("#photoimg").val('');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert('status Code:' + xhr.status + 'Error Message :' + thrownError);
            }
        });
        }
        });
    </script>
    </body>
</html>
