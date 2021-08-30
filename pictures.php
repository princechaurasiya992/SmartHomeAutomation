<?php
require 'includes/common.php';
require 'includes/is_welcomed.php';
require 'includes/remember_login.php';

if (isset($_SESSION['email'])) {
    $user_id = $_SESSION['id'];
}

$page = $_GET['page'];

$picture_select_query = "SELECT * FROM pictures";
$picture_selection_result = mysqli_query($con, $picture_select_query) or die(mysqli_error($con));

$picture_array = array();
$picture_id_array = array();
$picture_date_array = array();
$picture_user_id_array = array();
while ($row_picture = mysqli_fetch_array($picture_selection_result)) {
    array_push($picture_array, $row_picture["photo"]);
    array_push($picture_id_array, $row_picture["id"]);
    array_push($picture_date_array, $row_picture["date"]);
}
$total_pictures = count($picture_array);

$max_jump = 0;
if (($total_pictures % 12) != 0) {
    $max_jump = (($total_pictures - ($total_pictures % 12)) / 12 + 1);
} else {
    $max_jump = ($total_pictures / 12);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pictures</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="icons-1.4.0/font/bootstrap-icons.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <style>

        .myImgContainer {
            position: relative;
            float: left;
            width: 100%;
            padding-top: 100%;
        }

        .image {
            border: 0px solid #bbb;
            border-radius: 0px;
            box-shadow: 0px 0px 10px 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: 0.3s;
            display: inline-block;
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        @media only screen and (min-width: 600px) {
            .myImgContainer {
                width: 50%;
                padding-top: 50%;
            }

        }

        @media only screen and (min-width: 768px) {
            .myImgContainer {
                width: 33.33%;
                padding-top: 33.33%;
            }

        }

        @media only screen and (min-width: 1024px) {
            .myImgContainer {
                width: 25%;
                padding-top: 25%;
            }

        }

        <?php
        $i = 1;
        while ($i <= 12 && $i <= ($total_pictures - 12 * ($page - 1))) {
            ?>
        #myImg<?php echo $i; ?> {
            border-radius: 0px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg<?php echo $i; ?>:hover {
            opacity: 0.7;
        }

        <?php
        $i++;
    }
    ?>
        .modal {
            display: none;
            position: fixed;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 100;
        }

        .modal-content {
            position: fixed;
            overflow: auto;
            top: 0;
            left: 0;
            border-radius: 0;
            display: block;
            width: 100%;
            height: 100%;
            background-color: transparent;
        }

        .picture-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            height: 50px;
            width: 100%;
            cursor: pointer;
        }

        .picture-bar a {
            float: left;
            display: block;
            text-align: center;
            padding: 17px;
            color: #fff;
            background-color: #ec407a;
            font-size: 15px;
            height: 100%;
            width: 16.66%;
        }

        .picture-bar a:hover {
            background-color: #000;
        }

        .modal-content {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }
            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }
            to {
                transform: scale(1)
            }
        }

        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }

    </style>
    <style>
        .picture-option-btn-block {
            position: absolute;
            top: 0px;
            right: 0px;
            background-color: rgba(255, 255, 255, 0.6);
            color: #ec407a;
            padding: 5px;
            width: 30px;
            height: 30px;
        }

        .picture-option-btn-block:hover {
            background-color: #ec407a;
            color: #ffffff;
        }

        .picture-option-block {
            position: absolute;
            display: none;
            top: 0px;
            right: 30px;
            background-color: rgba(255, 255, 255, 1);
            box-shadow: 0px 0px 10px 5px rgba(0, 0, 0, 0.2);
            color: #ec407a;
            padding: 0px;
            width: 100px;
            height: fit-content;
        }

        .picture-option-block a, .comment-option-block a {
            text-decoration: none;
            padding: 5px;
            text-align: center;
            color: #ec407a;
            display: block;
        }

        .picture-option-block a:hover, .comment-option-block a:hover {
            background-color: #ec407a;
            color: #ffffff;
        }

        .text-block-caption {
            position: absolute;
            font-size: 13px;
            bottom: 0;
            margin: 0;
            background-color: rgba(255, 255, 255, 0.6);
            color: #000;
            padding: 5px;
            width: 100%;
        }

    </style>
    <style>

        form.type-message input[type=text] {
            padding: 10px;
            font-size: 17px;
            border: 1px solid #ec407a;
            border-radius: 20px;
            outline: none;
            float: left;
            width: 80%;
            height: 40px;
            background: #f1f1f1;
        }

        /* Style the submit button */
        form.type-message button {
            float: left;
            width: 20%;
            height: 40px;
            padding: 10px;
            background: #ec407a;
            color: white;
            font-size: 17px;
            border: 1px solid #ec407a;
            border-radius: 20px;
            border-left: none; /* Prevent double borders */
            outline: none;
            cursor: pointer;
        }

        form.type-message button:hover {
            outline: none;
            border-color: #000;
            background-color: #000;
            color: #fff;
        }

    </style>

</head>
<body>
<?php
include 'includes/header.php';
?>

<div class="content" id="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><a style="color: black;">Intruder's Pictures</a></li>
    </ul>

    <div class="container">
        <div class="jumbotron text-center">
            <h1 style="color: #ec407a">Intruder's Pictures</h1>
            <p><?php echo $total_pictures; ?> Photos</p>
            <a style="font-size: 20px; margin: 5px;" onclick="manualCamBtnFun()" name="" class="button btn">Click a
                picture manually</a>
        </div>

        <div style="width: 100%; overflow: auto; background-color: #eee; padding: 10px 16px;">
            <p style="display: inline; margin: 0; float: left; font-size: 18px;">Page - <?php echo $page; ?></p>

            <div style="float: right;" class="pagination-top">
                <?php
                if ($page != 1) {
                    ?>
                    <a href="pictures.php?page=<?php echo $page - 1; ?>" class="prev">Prev</a>
                    <?php
                } else {
                    ?>
                    <span class="prev">Prev</span>
                    <?php
                }
                ?>
                <p style="display: inline; font-size: 18px;">|</p>
                <?php
                if ($total_pictures > ($page * 12)) {
                    ?>
                    <a href="pictures.php?page=<?php echo $page + 1; ?>" class="next">Next</a>
                    <?php
                } else {
                    ?>
                    <span class="next">Next</span>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="row text-center" style="padding-top: 25px;">
            <?php
            $i = 0;
            while ($i < 12 && $i < ($total_pictures - 12 * ($page - 1))) {
                $pic = $i + 12 * ($page - 1);
                ?>


                <div class="myImgContainer">
                    <div style="height: 100%; width: 100%; position: absolute; top: 0; padding: 10px;">
                        <div class="image">
                            <img style="width: 100%; height: 100%; object-fit: cover;" id="myImg<?php echo $i + 1; ?>"
                                 src="img/pictures/<?php echo $picture_array[$pic]; ?>" alt="picture">
                            <div class="picture-option-block" id="pictureOptionBlock<?php echo $i + 1; ?>">
                                <ul style="text-align: left; list-style-type: none; width: 100%; padding-left: 0; margin-bottom: 0;">
                                    <li><a>Delete</a></li>
                                </ul>
                            </div>
                            <div class="picture-option-btn-block"
                                 onclick="pictureOptionBtnFunction('pictureOptionBtn<?php echo $i + 1; ?>', 'pictureOptionBlock<?php echo $i + 1; ?>')"><span
                                        id="pictureOptionBtn<?php echo $i + 1; ?>"
                                        class="bi bi-three-dots-vertical"></span></div>
                            <p class="text-block-caption" style="text-align: left;">Captured On
                                <span style="color: #ec407a;"><?php echo date('jS M-Y h:i A', strtotime('+5 hour +30 minutes', strtotime($picture_date_array[$pic]))); ?></span>
                            </p>
                        </div>
                    </div>

                    <!-- The Modal -->
                    <div id="myModal<?php echo $i + 1; ?>" class="modal">
                        <div class="modal-content">

                            <div class="picture-bar">
                                <a onclick="deleteFunction<?php echo $i + 1; ?>()" title="Delete"><span
                                            class="bi bi-trash"></span></a>
                                <a href="img/pictures/<?php echo $picture_array[$pic]; ?>"
                                   download="img/pictures/<?php echo $picture_array[$pic]; ?>" title="Download"><span
                                            class="bi bi-download"></span></a>
                                <a onclick="zoom_inFunction<?php echo $i + 1; ?>()" title="Zoom in"><span
                                            class="bi bi-zoom-in"></span></a>
                                <a onclick="zoom_outFunction<?php echo $i + 1; ?>()" title="Zoom out"><span
                                            class="bi bi-zoom-out"></span></a>
                                <a onclick="refreshFunction<?php echo $i + 1; ?>()" title="Refresh"><span
                                            class="bi bi-arrow-clockwise"></span></a>
                                <a onclick="closeFunction<?php echo $i + 1; ?>()" title="Close"><span
                                            class="bi bi-x-circle"></span></a>
                            </div>
                            <center><img
                                        style="width: 100%; top: 50%; left: 50%; position: absolute; z-index: -1; transform: translate(-50%, -50%);"
                                        id="img03<?php echo $i + 1; ?>"></center>
                        </div>
                    </div>


                    <script>
                        // Get the modal
                        var modal<?php echo $i + 1; ?> = document.getElementById("myModal<?php echo $i + 1; ?>");

                        // Get the image and insert it inside the modal - use its "alt" text as a caption
                        var img<?php echo $i + 1; ?> = document.getElementById("myImg<?php echo $i + 1; ?>");
                        var modalImg<?php echo $i + 1; ?> = document.getElementById("img03<?php echo $i + 1; ?>");
                        img<?php echo $i + 1; ?>.onclick = function () {
                            modal<?php echo $i + 1; ?>.style.display = "block";
                            modalImg<?php echo $i + 1; ?>.src = this.src;
                        }

                        // Get the <span> element that closes the modal
                        var span = document.getElementsByClassName("close")[0];


                        function closeFunction<?php echo $i + 1; ?>() {
                            modal<?php echo $i + 1; ?>.style.display = "none";
                        }

                        function zoom_inFunction<?php echo $i + 1; ?>() {
                            modalImg<?php echo $i + 1; ?>.style.width = (parseFloat(window.getComputedStyle(modalImg<?php echo $i + 1; ?>, null).getPropertyValue("width")) + 50) + "px";
                        }

                        function zoom_outFunction<?php echo $i + 1; ?>() {
                            modalImg<?php echo $i + 1; ?>.style.width = (parseFloat(window.getComputedStyle(modalImg<?php echo $i + 1; ?>, null).getPropertyValue("width")) - 50) + "px";
                        }

                        function refreshFunction<?php echo $i + 1; ?>() {
                            modalImg<?php echo $i + 1; ?>.style.width = "100%";
                        }

                        function deleteFunction<?php echo $i + 1; ?>() {
                            modalImg<?php echo $i + 1; ?>.style.width = "100%";
                        }

                    </script>

                </div>

                <?php
                $i++;
            }
            ?>
        </div>

        <div class="pagination col-full col">
            <?php
            if ($page != 1) {
                ?>
                <a href="pictures.php?page=<?php echo $page - 1; ?>"
                   class="prev">Prev</a>
                <?php
            } else {
                ?>
                <span class="prev">Prev</span>
                <?php
            }
            ?>

            <?php
            if ($total_pictures > 48) {
                ?>
                <?php
                if ($page <= 3) {
                    for ($i = 0; $i < 5; $i++) {
                        if ($i + 1 == $page) {
                            ?>
                            <span><?php echo $i + 1; ?></span>
                            <?php
                        } else {
                            ?>
                            <a href="pictures.php?page=<?php echo $i + 1; ?>"><?php echo $i + 1; ?></a>
                            <?php
                        }
                    }
                } else if ($page * 12 >= $total_pictures) {
                    for ($i = 0; $i < 5; $i++) {
                        if ($i == 4) {
                            ?>
                            <span><?php echo $page; ?></span>
                            <?php
                        } else {
                            ?>
                            <a href="pictures.php?page=<?php echo $page - 4 + $i; ?>"><?php echo $page - 4 + $i; ?></a>
                            <?php
                        }
                    }
                } else if (($page + 1) * 12 >= $total_pictures) {
                    for ($i = 0; $i < 5; $i++) {
                        if ($i == 3) {
                            ?>
                            <span><?php echo $page; ?></span>
                            <?php
                        } else {
                            ?>
                            <a href="pictures.php?page=<?php echo $page - 3 + $i; ?>"><?php echo $page - 3 + $i; ?></a>
                            <?php
                        }
                    }
                } else {
                    ?>
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i == 3) {
                            ?>
                            <span><?php echo $page; ?></span>
                            <?php
                        } else {
                            ?>
                            <a href="pictures.php?page=<?php echo $page + $i - 3; ?>"><?php echo $page + $i - 3; ?></a>
                            <?php
                        }
                    }
                }
            } else {
                for ($i = 0; ($i * 12) < $total_pictures; $i++) {
                    if ($i + 1 == $page) {
                        ?>
                        <span><?php echo $i + 1; ?></span>
                        <?php
                    } else {
                        ?>
                        <a href="pictures.php?page=<?php echo $i + 1; ?>"><?php echo $i + 1; ?></a>
                        <?php
                    }
                }
            }
            ?>
            <?php
            if ($total_pictures > ($page * 12)) {
                ?>
                <a href="pictures.php?page=<?php echo $page + 1; ?>"
                   class="next">Next</a>
                <?php
            } else {
                ?>
                <span class="next">Next</span>
                <?php
            }
            ?>

        </div>
        <div class="pagination col-full col">
            <form class="jump_to_page_form" method="POST"
                  action="jump_to_page_script.php?id=<?php echo $category_id; ?>&page=<?php echo $page; ?>">
                <input class="jump_to_page_input" type="number" max="<?php echo $max_jump; ?>" min="1"
                       name="jump_to_page" placeholder="<?php echo "1-" . $max_jump; ?>">
                <input type="submit" class="jump_to_page_btn" value="Jump">
            </form>
        </div>

    </div>
</div>

<?php
include 'includes/footer.php';
?>

<script>
    window.onscroll = function () {
        scrollFunction();
        myFunction();
    };
    var content = document.getElementById("content");
    var navbar = document.getElementById("myNavbar");
    var leftnav = document.getElementById("left-navigation-bar");
    var sticky = navbar.offsetTop;

    //Get the button
    var mybutton = document.getElementById("myBtn");

    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky");
            navbar.style.position = "fixed";
            content.classList.add("content-padding");
        } else {
            navbar.classList.remove("sticky");
            navbar.style.position = "relative";
            content.classList.remove("content-padding");
        }
    }

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    var categoriesbutton = document.getElementById("categoriesBtn");
    var categoriesbuttonchevron = document.getElementById("categoriesButtonChevron");
    var leftnavbar = document.getElementById("leftnav");

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    if (window.addEventListener) {
        window.addEventListener("scroll", function () {
            fix_sidemenu();
        });
        window.addEventListener("resize", function () {
            fix_sidemenu();
        });
        window.addEventListener("touchmove", function () {
            fix_sidemenu();
        });
        window.addEventListener("load", function () {
            fix_sidemenu();
        });
    } else if (window.attachEvent) {
        window.attachEvent("onscroll", function () {
            fix_sidemenu();
        });
        window.attachEvent("onresize", function () {
            fix_sidemenu();
        });
        window.attachEvent("ontouchmove", function () {
            fix_sidemenu();
        });
        window.attachEvent("onload", function () {
            fix_sidemenu();
        });
    }

    function fix_sidemenu() {
        var top = window.pageYOffset;

        if (top == 0) {
            document.getElementById("leftnav").style.top = "130px";
        }
        if (top > 0 && top < sticky) {
            document.getElementById("leftnav").style.top = (130 - top) + "px";
        }
        if (top > sticky) {
            document.getElementById("leftnav").style.top = "50px";
        }

        if (top > sticky) {
            document.getElementById("left-navigation-bar").style.paddingTop = "50px";
        } else {
            document.getElementById("left-navigation-bar").style.paddingTop = (130 - top) + "px";
        }
    }
</script>

<script>
    document.getElementById("pictures").classList.add("active");
</script>
<script src="js/optionBtnScript.js"></script>
<script src="js/manual_cam_script.js"></script>

</body>
</html>
