<?php

//Include authentication
require("process/auth.php");

//Include database connection
require("../config/db.php");

//Include class Voters
require("classes/Voters.php");

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Login</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style_admin.css">
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
                $name       = trim($_POST['name']);
                $course     = trim($_POST['course']);
                $year       = trim($_POST['year']);
                $stud_id    = trim($_POST['stud_id']);
                $voter_id   = trim($_POST['voter_id']);

                $updateVoter = new Voters();
                $rtnUpdateVoter = $updateVoter->UPDATE_VOTER($name, $course, $year, $stud_id, $voter_id);

            }
            ?>
            <h4>Edit Student's Information</h4><hr>
            <?php
            if(isset($_GET['id'])) {
                $id = trim($_GET['id']);

                $editVoter = new Voters();
                $rtnEditVoter = $editVoter->EDIT_VOTER($id);
            }
            ?>

            <?php if($rtnEditVoter) { ?>
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" role="form">
                <?php while($rowVoter = $rtnEditVoter->fetch_assoc()) { ?>
                <div class="form-group-sm">
                    <label for="name">Name</label>
                    <input required type="text" name="name" class="form-control" placeholder="LName, FName MI." value="<?php echo $rowVoter['name']; ?>">
                </div>
                <div class="form-group-sm">
                    <label for="course">Course</label>
                    <select required name="course" class="form-control">
                        <option value="<?php echo $rowVoter['course']; ?>"><?php echo $rowVoter['course']; ?></option>
                        <option value="">*****Select Course*****</option>
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
                        <option value="<?php echo $rowVoter['year']; ?>"><?php echo $rowVoter['year']; ?></option>
                        <option value="1st">1st Year</option>
                        <option value="2nd">2nd Year</option>
                        <option value="3rd">3rd Year</option>
                        <option value="4th">4th Year</option>
                    </select>
                </div>
                <div class="form-group-sm">
                    <label for="stud_id">Student ID No.</label>
                    <input required type="text" name="stud_id" class="form-control" value="<?php echo $rowVoter['stud_id']; ?>">
                </div><hr>
                <div class="form-group-sm">
                    <input type="hidden" name="voter_id" value="<?php echo $rowVoter['id']; ?>">
                    <input type="submit" name="update" value="Update" class="btn btn-info">
                </div>
                <?php } //End while ?>
            </form>
                <?php $rtnEditVoter->free(); ?>
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
<script src="../assets/js/bootstrap.min.js"></script>

</body>
</html>