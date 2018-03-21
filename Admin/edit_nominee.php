<?php

//Include authentication
require("process/auth.php");

//Include database connection
require("../config/db.php");

//Include class Organization
require("classes/Organization.php");

//Include class Position
require("classes/Position.php");

//Include class Nominees
require("classes/Nominees.php");

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Login</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style_admin.css">

    <script>
        function getPos(val) {
            $.ajax({
                type: "POST",
                url: "get_pos.php",
                data: 'org='+val,
                success: function(data) {
                    $("#pos-list").html(data);
                }
            });
        }
    </script>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">DIU Distribution System</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="admin_page.php"><span class="glyphicon glyphicon-home"></span></a></li>
                <li><a href="add_org.php"><span class="glyphicon glyphicon-plus-sign"></span>Add Organization</a></li>
                <li><a href="add_pos.php"><span class="glyphicon glyphicon-plus-sign"></span>Add Distribution Item</a></li>
                <li><a href="add_nominees.php"><span class="glyphicon glyphicon-plus-sign"></span>Add Access Parson</a></li>
                <li><a href="add_voters.php"><span class="glyphicon glyphicon-plus-sign"></span>Add Student</a></li>
                <li><a href="vote_result.php"><span class="glyphicon glyphicon-plus-sign"></span>Reports</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="process/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->

    </div><!-- /.container-fluid -->
</nav>
<!-- End Header -->





<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?php
            if(isset($_POST['update'])) {
                $org        = trim($_POST['organization']);
                $pos        = trim($_POST['position']);
                $name       = trim($_POST['name']);
                $course     = trim($_POST['course']);
                $year       = trim($_POST['year']);
                $stud_id    = trim($_POST['stud_id']);
                $nominee_id = trim($_POST['nom_id']);

                $updateNominee = new Nominees();
                $rtnUpdateNominee = $updateNominee->UPDATE_NOMINEE($org, $pos, $name, $course, $year, $stud_id, $nominee_id);

            }
            ?>
            <h4>Edit Access Parson Information</h4><hr>

            <?php
            if(isset($_GET['id'])) {
                $nom_id = trim($_GET['id']);

                $editNominee = new Nominees();
                $rtnEditNominee = $editNominee->EDIT_NOMINEE($nom_id);
            }
            ?>

            <?php if($rtnEditNominee) { ?>
                <?php while($rowNominee = $rtnEditNominee->fetch_assoc()) { ?>
                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" role="form">
                    <?php
                    $readOrg = new Organization();
                    $rtnReadOrg = $readOrg->READ_ORG();
                    ?>
                    <div class="form-group-sm">
                        <label for="organization">Organization</label>
                        <?php if($rtnReadOrg) { ?>
                            <select required name="organization" class="form-control" id="org-list" onchange="getPos(this.value);">
                                <option value="<?php echo $rowNominee['org']; ?>"><?php echo $rowNominee['org']; ?></option>
                                <?php while($rowOrg = $rtnReadOrg->fetch_assoc()) { ?>
                                    <option value="<?php echo $rowOrg['org']; ?>"><?php echo $rowOrg['org']; ?></option>
                                <?php } //End while ?>
                            </select>
                            <?php $rtnReadOrg->free(); ?>
                        <?php } //End if ?>
                    </div>
                    <div class="form-group-sm">
                        <label for="position">Distribution Item</label>
                        <select required name="position" class="form-control" id="pos-list">
                            <option value="<?php echo $rowNominee['pos']; ?>"><?php echo $rowNominee['pos']; ?></option>
                        </select>
                    </div>
                    <div class="form-group-sm">
                        <label for="name">Access Parson Name</label>
                        <input required type="text" name="name" class="form-control" value="<?php echo $rowNominee['name']; ?>">
                    </div>
                    <div class="form-group-sm">
                        <label for="course">Department</label>
                        <select required name="course" class="form-control">
                        <option value="">*****Select Department*****</option>
                        <option value="CSE">Computer Science Engineering</option>
                        <option value="EEE">Electrical and Electronics Engineering</option>
                        <option value="MCT">MCT</option>
                        <option value="ETE">Electronic & Telecommunication Engineering</option>
                        <option value="BBA">Bachelor of Business Administration</option>
                        </select>
                    </div>
                    <div class="form-group-sm">
                        <label for="year">Year</label>
                        <select required name="year" class="form-control">
                            <option value="">*****Select Year*****</option>
                        <option value="1st">1st Year</option>
                        <option value="2nd">2nd Year</option>
                        <option value="3rd">3rd Year</option>
                        <option value="4th">4th Year</option>
                        </select>
                    </div>
                    <div class="form-group-sm">
                        <label for="stud_id">Total Item Input Quantity</label>
                        <input required type="text" name="stud_id" class="form-control" value="<?php echo $rowNominee['stud_id']; ?>">
                    </div>
                    <hr/>
                    <div class="form-group-sm">
                        <input type="hidden" name="nom_id" value="<?php echo $rowNominee['id']; ?>">
                        <input type="submit" name="update" value="Update" class="btn btn-info">
                    </div>
                </form>
                <?php } //End while ?>
                <?php $rtnEditNominee->free(); ?>
            <?php } //End if ?>
        </div>
    </div>
</div>






<!-- Footer -->
<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">

    <div class="container">
        <div class="navbar-text pull-left">
            Copyright © 2018 SALEH AHMED (CSE IT) Daffodil International University.
        </div>
    </div>

</nav>
<!-- End Footer -->

<script src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>

</body>
</html>