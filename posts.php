<?php
include('lib/mysql.class.php');
$db = new MySQL();
$db1 = new MySQL();

$filter = false;
$category = "All Categories";

$filter_keyword = "";
$filter_category = "";
$filter_formatted_address = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $filter = true;
    extract($_POST, EXTR_PREFIX_ALL, "filter");

    if ($filter_category) {
        $sql = "SELECT name FROM category WHERE id = " . MySQL::SQLValue($filter_category, MySQL::SQLVALUE_NUMBER);
        $category = $db->QuerySingleValue($sql);
    }
}
else {
    if (isset($_GET["cat_id"])) {
        $filter = true;
        $sql = "SELECT name FROM category WHERE id = " . MySQL::SQLValue($_GET["cat_id"], MySQL::SQLVALUE_NUMBER);
        $category = $db->QuerySingleValue($sql);
        $filter_category = $_GET["cat_id"];
    }
    else if (isset($_GET["upvote"])) {
        $id = MySQL::SQLValue($_GET["post_id"], MySQL::SQLVALUE_NUMBER);

        $sql = "SELECT votes FROM complaint WHERE id = " . $id;
        $votes = $db->QuerySingleValue($sql);
        $votes++;

        $values = array();
        $values["votes"] = $votes;
        if (!$db->UpdateRows("complaint", $values, array("id" => $id))) die($db->error());
    }
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Ikhtiyaar - Browse Complaints</title>

        <link rel="icon" type="image/png" href="assets/images/logo-blue.png">

        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"> <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="assets/css/grid30.css" />

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Crimson+Text:400,400italic,600' rel='stylesheet' type='text/css'>

        <!--<link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic|Droid+Serif:400,700,400italic|PT+Serif:400,700,400italic|Noto+Serif:400,400italic,700|Libre+Baskerville:400,400italic,700' rel='stylesheet' type='text/css'>-->
        
       
        <link rel="stylesheet" type="text/css" href="assets/css/main.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/lightcase.css" />

        <script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements styling and media queries -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>

    <body>

        <header class="top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="logo">
                            <img src="assets/images/logo-white.png" />
                            <h1>Ikhtiyaar</h1>
                        </div>
                    </div>

                    <div class="col-md-18 hidden-sm hidden-xs">
                        <a href="index.php">Home</a>
                        <a href="posts.php" class="active">Complaints</a>
                        <a href="#">News</a>
                        <a href="#">About</a>
                        <a href="#">Contact</a>
                    </div>

                    <div class="col-sm-5 text-right">
                        <button onclick="javascript: window.open('index.php?form_only=true', '_blank', 'width=400, height=500, left=450, top=100, menubar=0, resizable=0, status=0, titlebar=0, toolbar=0, location=0')" class="btn btn-white btnPost"><span class="glyphicon glyphicon-share-alt"></span> Post Complaint</button>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">

            <form action="posts.php" method="POST">
                <div class="row">

                    <h4 class="heading">Filter Posts</h4>

                    <div class="col-md-10 form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Filter by keyword" name="keyword" id="keyword" value="<?php echo ($filter ? $filter_keyword : ''); ?>">
                        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                    </div>

                    <div class="col-md-10 form-group">
                        <select class="form-control" name="category">
                            <option value="" data-hidden="true">Filter by category</option>
                            <?php
                            $sql = "SELECT * FROM category";
                            $db->Query($sql);
                            while ($row = $db->Row()) :
                            ?>
                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-10 form-group">
                        <input type="text" class="form-control" placeholder="Filter by location" name="location" id="location">
                        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>

                        <div id="location-details">
                            <input name="formatted_address" type="hidden" value="">
                            <input name="locality" type="hidden">
                            <input name="country" type="hidden">
                        </div>
                    </div>

                    <!--
<div class="col-md-6 form-group has-feedback">
<button type="button" id="btnAddDuration" class="btn btn-white btn-block"><span class="glyphicon glyphicon-calendar"></span>&nbsp; Filter by date/time</button>    
</div>
-->

                </div>

                <div class="row">
                    <div class="col-md-30 text-center">
                        <button type="submit" id="btnShowPosts" class="btn btn-default btn-lg hvr-shutter-in-vertical"><span class="glyphicon glyphicon-search"></span>&nbsp; Show Posts</button>
                    </div>
                </div>

            </form>

            <div class="row content">

                <div class="text-center">
                    <h1 class="page-title">
                        <span class="glyphicon glyphicon-pushpin"></span>&nbsp;
                        Complaints related to <strong><?php echo $category; ?></strong>

                        <?php echo ($filter_formatted_address ? "in <strong>{$filter_formatted_address}</strong>" : ""); ?>
                        <?php echo ($filter_keyword ? "<br>containing the keyword '<strong>$filter_keyword</strong>" : ""); ?>
                    </h1>
                </div>

                <div class="col-md-8">
                    <div class="city-profile">
                        <h1 class="title">Peshawar</h1>
                        <p class="desc">Peshawar is the capital of Khyber Pakhtunkhwa of Pakistan. Peshawar is the largest city of Khyber Pakhtunkhwa and by the 1998 census was the ninth-largest city of Pakistan.</p>
                        <div class="photo"><img src="assets/images/peshawar.jpg" class="img-responsive"></div>
                    </div>
                </div>

                <div class="col-md-22">

                    <?php
                    if (!$filter) {
                        $sql = "SELECT c.*, cat.name AS category, u.name AS username, u.profile_link, u.profile_pic
                            FROM complaint AS c
                            INNER JOIN category AS cat ON cat.id=c.category_id
                            INNER JOIN user AS u ON u.id=c.user_id
                            GROUP BY c.id ORDER BY c.id DESC";
                    }
                    else {
                        $sql = "SELECT c.*, cat.name AS category, u.name AS username, u.profile_link, u.profile_pic
                            FROM complaint AS c
                            INNER JOIN category AS cat ON cat.id=c.category_id
                            INNER JOIN user AS u ON u.id=c.user_id
                            WHERE 1=1";
                        if ($filter_keyword) $sql .= " AND (c.title LIKE '%$filter_keyword%' OR c.details LIKE '%$filter_keyword%')";
                        if ($filter_formatted_address) $sql .= " AND c.location LIKE '%$filter_formatted_address%'";
                        if ($filter_category) $sql .= " AND cat.id=$filter_category";
                        $sql .= " GROUP BY c.id ORDER BY c.id DESC";
                    }

                    $db->Query($sql);

                    if (!$db->RowCount()):
                    echo "<div class='post'><h4>No complaints found!</h4> Sorry, there are no complaints present in the database matching your criteria.</div>";
                    else :

                    while ($post = $db->Row()):
                    ?>

                    <div class="post">
                        <div class="row post-header">
                            <div class="col-sm-15">
                                <div class="post-pic"><img src="<?php echo $post->profile_pic; ?>"></div>
                                <div style="overflow: hidden;">
                                    <div class="post-name"><a href="<?php echo $post->profile_link; ?>" target="_blank" title="Click to goto user's FB profile"><?php echo $post->username; ?></a></div>
                                    <div class="post-num">#<?php echo str_pad($post->id, 5, "0", STR_PAD_LEFT); ?></div>
                                </div>
                            </div>
                            <div class="col-sm-15 meta">
                                <span class="post-category" title="Category"><span class="glyphicon glyphicon-tag"></span>&nbsp; <?php echo $post->category; ?></span>
                                <span class="post-date" title="Complaint date"><span class="glyphicon glyphicon-time"></span>&nbsp; <?php echo date_format(date_create($post->datetime), 'j F, Y \a\t g:i A'); ?></span>
                            </div>
                        </div>

                        <div class="row post-content">
                            <div class="col-sm-30 post-main">
                                <p><strong><?php echo $post->title; ?></strong></p>
                                <p><?php echo $post->details; ?></p>
                                
                                <div class="post-media">
                                    <?php
                                    $sql = "SELECT * FROM media WHERE complaint_id = " . $post->id;
                                    $db1->Query($sql);

                                    while ($media = $db1->Row()):
                                    ?>
                                    <a data-rel="lightcase:myCollection <?php echo $media->complaint_id; ?>" href="<?php echo $media->path; ?>" target="_blank"><img src="lib/thumb.php?src=/ikhtiyaar/<?php echo $media->path; ?>&w=160&h=160"></a>
                                    <?php
                                    endwhile; ?>
                                    <div class="clear"></div>
                                </div>
                            </div>

                            <div class="col-sm-15 post-location" title="Location">
                                <span class="glyphicon glyphicon-map-marker"></span>&nbsp; <?php echo $post->location; ?>
                            </div>
                            <div class="col-sm-15 post-actions">
                                <a href="#" data-target="#comment-modal" data-toggle="modal"><span class="glyphicon glyphicon-edit"></span> Comment <span class="badge">0</span></a> &nbsp;&nbsp; 
                                <a href="posts.php?upvote=true&post_id=<?php echo $post->id; ?>"><span class="glyphicon glyphicon-thumbs-up"></span> I Support <span class="badge"><?php echo $post->votes; ?></span></a>
                            </div>
                        </div>
                    </div>
                    <?php
endwhile;
endif;
                    ?>


                </div>

            </div>
        </div>

        <footer>
            <div class="col-sm-30 text-center">
                Copyright &copy; 2016 - All rights reserved. Developed by Hassan Ahmed, Sadiq Khan &amp; Salman Haider.
            </div>
        </footer>

        <!-- Comment modal starts-->
        <div class="modal" id="comment-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div>
                        <form action="">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                <h4 class="modal-title text-center">Comment on Complaint</h4>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <textarea placeholder="Please write your comment here." name="comment" class="form-control" id="" cols="20" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Post Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Comment modal ends -->


        <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
        <script type="text/javascript" src="assets/js/jquery.geocomplete.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.lightcase.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/script.js"></script>

    </body>
</html>
