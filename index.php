<?php

include('lib/mysql.class.php');
$db = new MySQL();

$form_only = false;
if (isset($_GET["form_only"]) && $_GET["form_only"] == true) {
    $form_only = true;
}

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Ikhtiyaar</title>

        <link rel="icon" type="image/png" href="assets/images/logo-blue.png">

        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"> <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="assets/css/grid30.css" />

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Crimson+Text:400,400italic,600' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" type="text/css" href="assets/css/dropzone.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/main.css" />

        <script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements styling and media queries -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>

    <body>

        <div class="container">

            <?php if (!$form_only): ?>

            <header class="home">
                <div class="row">
                    <div class="col-sm-30 text-center">
                        <div class="logo">
                            <img src="assets/images/logo-blue.png" />
                            <h1>Ikhtiyaar</h1>
                        </div>
                        <p class="desc">An initiative to raise awareness in public of Khyber Pukhtunkhwa and provide them with a platform to give voice to their rightful needs.</p>
                    </div>
                </div>
            </header>

            <?php else: ?>
            <br>
            <?php endif; ?>

            <div class="row">
                <div class="col-sm-30">
                    <div class="panel panel-default">
                        <div class="panel-body post-box">
                            <h4 class="heading">Post Complaint</h4>

                            <form action="process.php" class="dropzone" method="post" enctype="multipart/form-data" id="myAwesomeDropzone">

                                <input type="hidden" name="fb_access_token" value="">

                                <div class="row"> 

                                    <div class="col-md-10 form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="Complaint title" name="title" id="title" required>
                                        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                                    </div>

                                    <div class="col-md-10 form-group">
                                        <select class="form-control" name="category_id">
                                            <?php
$sql = "SELECT * FROM category";
$db->Query($sql);
while ($row = $db->Row()) :
                                            ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                            <?php
endwhile;
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-10 form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="Location" name="location" id="location" required>
                                        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>

                                        <div id="location-details">
                                            <input name="formatted_address" type="hidden" value="" id="formatted_address">
                                            <input name="locality" type="hidden">
                                            <input name="country" type="hidden">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-30">
                                        <div class="form-group">
                                            <textarea name="details" placeholder="Enter here the details about your update or complaint" class="form-control" id="details" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-30">
                                        <div class="dropzone-previews">
                                            <div><span class="glyphicon glyphicon-camera"></span>&nbsp; You can drag n drop your photos here. You may upload upto 5 photos.</div>
                                        </div>
                                        <div class="dz-message"></div> <!-- so as not to show the default message -->
                                    </div>
                                </div>

                                <div class="alert alert-success message message-success">
                                    <span class="glyphicon glyphicon-ok"></span> <span class="text"></span>
                                </div>
                                <div class="alert alert-danger message message-error">
                                    <!-- Here goes the error (if any) -->
                                </div>

                                <div class="row">
                                    <div class="col-sm-30 text-center">
                                        <button type="submit" id="btnPost" class="btn btn-default btn-lg hvr-shutter-in-vertical"><span class="glyphicon glyphicon-share-alt"></span> <span class="text">Post it!</span></button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <?php if (!$form_only): ?>
            <br>
            <h4 class="heading">Citizen Services</h4>

            <div class="row grid">
                <a href="posts.php?cat_id=1">
                    <div class="cat-container">

                        <div class="cat-block b1">
                            <div class="title"><span class="num">1</span>Education</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-education.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php?cat_id=2">
                    <div class="cat-container">
                        <div class="cat-block b2">
                            <div class="title"><span class="num">2</span>Emergency<br>Services</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-emergency.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php?cat_id=3">
                    <div class="cat-container">
                        <div class="cat-block b3">
                            <div class="title"><span class="num">3</span>Environment</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-environment.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php?cat_id=4">
                    <div class="cat-container">
                        <div class="cat-block b4">
                            <div class="title"><span class="num">4</span>Food</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-food.svg" />
                            </div>
                        </div>
                    </div>
                </a>


                <a href="posts.php?cat_id=5">
                    <div class="cat-container">
                        <div class="cat-block b5">
                            <div class="title"><span class="num">5</span>Healthcare</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-healthcare.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php?cat_id=6">
                    <div class="cat-container">
                        <div class="cat-block b6">
                            <div class="title"><span class="num">6</span>Infrastructure</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-infrastructure.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php?cat_id=7">
                    <div class="cat-container">
                        <div class="cat-block b7">
                            <div class="title"><span class="num">7</span>Law &amp;<br>Order</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-law.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php?cat_id=8">
                    <div class="cat-container">
                        <div class="cat-block b8">
                            <div class="title"><span class="num">8</span>Power</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-power.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php?cat_id=9">
                    <div class="cat-container">
                        <div class="cat-block b9">
                            <div class="title"><span class="num">9</span>Roads</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-roads.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php?cat_id=10">
                    <div class="cat-container">
                        <div class="cat-block b10">
                            <div class="title"><span class="num">10</span>Sewerage &amp; Sanitation</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-sanitation.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php?cat_id=11">
                    <div class="cat-container">
                        <div class="cat-block b11">
                            <div class="title"><span class="num">11</span>Transportation</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-transportation.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php?cat_id=12">
                    <div class="cat-container">
                        <div class="cat-block b12">
                            <div class="title"><span class="num">12</span>Water</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-water.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php?cat_id=13">
                    <div class="cat-container">
                        <div class="cat-block b13">
                            <div class="title"><span class="num">13</span>Other</div>
                            <div class="icon text-center">
                                <img src="assets/images/icon-other.svg" />
                            </div>
                        </div>
                    </div>
                </a>

                <a href="posts.php">
                    <div class="cat-container">
                        <div class="cat-block b14">
                            <a href="http://www.google.com">
                                <div class="title" style="color: #000;">All Citizen<br>Services</div>
                                <div class="icon text-center">
                                    <img src="assets/images/icon-all-categories.png" />
                                </div>
                            </a>
                        </div>
                    </div>
                </a>

            </div>

            <footer>
                <div class="col-sm-30 text-center">
                    Copyright &copy; 2016 - All rights reserved. Developed by Hassan Ahmed, Sadiq Khan &amp; Salman Haider.
                </div>
            </footer>

            <?php endif; ?>

        </div>

        <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
        <script type="text/javascript" src="assets/js/jquery.geocomplete.min.js"></script>
        <script type="text/javascript" src="assets/js/dropzone.min.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/script.js"></script>

        <script type="text/javascript">
            Dropzone.options.myAwesomeDropzone = {

                url: "process.php",
                paramName: "media",
                addRemoveLinks: true,
                clickable: ".dropzone-previews",
                previewsContainer: ".dropzone-previews",
                dictRemoveFile: "Remove",
                acceptedFiles: "image/*",
                autoDiscover: false,

                // The main configuration (for combining normal form with dropzonejs)
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 5,

                // The setting up of the dropzone
                init: function() {
                    var myDropzone = this;

                    // First change the button to actually tell Dropzone to process the queue.
                    $(".dropzone #btnPost").on('click',function(e) {
                        // Make sure that the form isn't actually being sent.
                        e.preventDefault();

                        if ($("#title").val() && $("#details").val() && $("#formatted_address").val() && myDropzone.getQueuedFiles().length > 0) { 
                            fb_login(myDropzone);
                        } else {
                            show_error("Error: Please fill in all the required fields first!");    
                        }

                    });
                },

                queuecomplete: function(file, responseText) {
                    this.removeAllFiles();
                },

                successmultiple: function(file, response) {
                    enableSubmitButton();
                    if (response.substring(0, 6) == "Error:") {
                        $("form.dropzone .message-error").html(response);
                        $("form.dropzone .message-error").fadeIn("fast").delay(6000).fadeOut("slow");
                    }
                    else {
                        // Clear fields
                        $("form.dropzone #title").val("");
                        $("form.dropzone #details").val("");
                        // Show success message
                        $("form.dropzone .message-success .text").html(response);
                        $("form.dropzone .message-success").fadeIn("slow").delay(6000).fadeOut("slow");
                    }
                },

                error: function(file, errorMessage) {
                    enableSubmitButton();
                    if (!$("form.dropzone .message-error").is(":visible")) {
                        $("form.dropzone .message-error").html(errorMessage);
                        $("form.dropzone .message-error").fadeIn("fast").delay(6000).fadeOut("slow");
                    }
                }
            }

            function enableSubmitButton() {
                $('#btnPost .text').html("Post it!");
                $('#btnPost').prop('disabled', false);
            }
            function disableSubmitButton() {
                $('#btnPost .text').html("Please wait...");
                $('#btnPost').prop('disabled', true);
            }
            
            function show_error(errorMessage) {
                $("form.dropzone .message-error").html(errorMessage);
                $("form.dropzone .message-error").fadeIn("fast").delay(6000).fadeOut("slow");
            }

        </script>
    </body>
</html>