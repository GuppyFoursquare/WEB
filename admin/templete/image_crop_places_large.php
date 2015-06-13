<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo SITEPATH; ?>css/cropper.css">
<style>
    #test-modal{
        padding:2%;
    }
    .preview-lg {
        height: 128px;
        width: 220px;
    }
</style>
<td height="400" align="center" valign="top" class="adminleft"><div class="admintitalbox">
        <div class="admintitalboxleft"><?php include("includes/navigation/left_menu.php"); ?></div>
        <div class="admintitalboxright"><div class="mid_contain">
                <table border="0" cellpadding="" cellspacing="0" align="center" width="98%" >
                    <tbody>
                        <tr>
                            <td>

                                <div id="test-modal" class="white-popup-block mfp-hide">
                                    <div class="container-fluid eg-container" id="basic-example">
                                        <div class="row eg-main">
                                            <div class="col-sm-9">
                                                <div class="eg-wrapper">
                                                    <img class="cropper" src="<?= "../".PLACES_ORIGINAL_IMAGE_PATH . $sImageName ?>" alt="Picture">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="eg-preview clearfix">
                                                    <div class="preview preview-lg"></div>
                                                    <!--          <div class="preview preview-md"></div>
                                                              <div class="preview preview-sm"></div>
                                                              <div class="preview preview-xs"></div>-->
                                                </div>
                                                <form action="crop.php" method="post" >
                                                    <div class="eg-data">
                                                        <input class="form-control" id="imagePath" name="imagePath" type="hidden" value="<?= $sImageName ?>">

                                                        <input class="form-control" id="dataX" name="dataX" type="hidden" placeholder="x">


                                                        <input class="form-control" id="dataY" name="dataY" type="hidden" placeholder="y">

                                                        <input class="form-control" id="dataW" name="dataW" type="hidden" placeholder="width">

                                                        <input class="form-control" id="dataH" name="dataH" type="hidden" placeholder="height">

                                                        <input class="button" id="cropSubmit" type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
                                                    </div>
                                                </form>

                                            </div>

                                        </div>
                                    </div>
                                    </div>
                            </td>
                        </tr>
                    </tbody></table>

            </div>
        </div> </td>
</tr>
<link href="<?php echo SITEPATH; ?>css/magnific-popup.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" language="javascript" src="includes/js/jquery.js"></script>-->
<script type="text/javascript" language="javascript" src="<?php echo SITEPATH; ?>js/jquery.magnific-popup.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        (function($) {
            $(window).load(function () {

                $.magnificPopup.open({
                    items: {
                        src: '#test-modal'
                    },
                    type: 'inline'
                });


            });

        })(jQuery);
    });
</script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="<?php echo SITEPATH; ?>js/cropper.js"></script>
<script>
    $(window).load(function () {
        var $cropper = $(".cropper"),
        $dataX = $("#dataX"),
        $dataY = $("#dataY"),
        $dataH = $("#dataH"),
        $dataW = $("#dataW"),
        cropper;

        $cropper.cropper({
            aspectRatio: <?php echo PLACES_LARGE_IMAGE_WIDTH;?> / <?php echo PLACES_LARGE_IMAGE_HEIGHT;?>,
            data: {
                x: 420,
                y: 50,
                width: 220,
                height: 128
            },
            preview: ".preview",

            // autoCrop: false,
            // dragCrop: false,
            // modal: false,
            // moveable: false,
            // resizeable: false,

            // maxWidth: 480,
            // maxHeight: 270,
            // minWidth: 160,
            // minHeight: 90,

            done: function(data) {
                $dataX.val(data.x);
                $dataY.val(data.y);
                $dataH.val(data.height);
                $dataW.val(data.width);
            }
        });

        cropper = $cropper.data("cropper");

        $cropper.on({
            "build.cropper": function(e) {
                console.log(e.type);
                // e.preventDefault();
            },
            "built.cropper": function(e) {
                console.log(e.type);
                // e.preventDefault();
            },
            "render.cropper": function(e) {
                console.log(e.type);
                // e.preventDefault();
            }
        });

        $("#enable").click(function() {
            $cropper.cropper("enable");
        });

        $("#disable").click(function() {
            $cropper.cropper("disable");
        });

        $("#reset").click(function() {
            $cropper.cropper("reset");
        });

        $("#reset-deep").click(function() {
            $cropper.cropper("reset", true);
        });

        $("#release").click(function() {
            $cropper.cropper("release");
        });

        $("#destroy").click(function() {
            $cropper.cropper("destroy");
        });

        $("#setData").click(function() {
            $cropper.cropper("setData", {
                x: $dataX.val(),
                y: $dataY.val(),
                width: $dataW.val(),
                height:$dataH.val()
            });
        });

        $("#setAspectRatio").click(function() {
            $cropper.cropper("setAspectRatio", $("#aspectRatio").val());
        });

        $("#setImgSrc").click(function() {
            $cropper.cropper("setImgSrc", $("#imgSrc").val());
        });

        $("#getImgInfo").click(function() {
            $("#showInfo").val(JSON.stringify($cropper.cropper("getImgInfo")));
        });

        $("#getData").click(function() {
            $("#showData").val(JSON.stringify($cropper.cropper("getData")));
        });
    });

    $.magnificPopup.instance.close = function () {

        window.location.href="image_crop.php?iset=1";
        $.magnificPopup.proto.close.call(this);

    };
    
</script>
<?php include("footer.inc.php"); ?>