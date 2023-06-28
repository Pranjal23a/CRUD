<?php
session_start();
include "db.php";

if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_name'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
        <link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="bootstrap-4.4.1/js/juqery_latest.js"></script>
        <script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <title>CRUD</title>
        <!-- google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&family=Ubuntu&display=swap" rel="stylesheet">

    </head>

    <body style="background-color: gainsboro;">
        <div class="top">
            <span>Admin ID: <?php echo $_SESSION['admin_id']; ?></span>
            <span style="float: right;">Admin Name: <?php echo $_SESSION['admin_name']; ?></span>
            <a href="logout.php" class="btn btn-secondary" role="button">Log Out</a>
        </div>

        <br><br>
        <div class="main">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home" class="btn btn-primary">Student Information</a></li>
                <li><a data-toggle="tab" href="#menu1" class="btn btn-success">Add Student</a></li>
                <li><a data-toggle="tab" href="#menu2" class="btn btn-warning">Edit Student</a></li>
                <li><a data-toggle="tab" href="#menu3" class="btn btn-danger">Delete Student</a></li>
            </ul>
            <hr>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="data">
                        <h3>Student Information</h3>
                        <br>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Batch</th>
                                    <th>Department</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sql = "SELECT * FROM student WHERE student_check=1 ORDER BY id";
                                $result = mysqli_query($conn, $sql);

                                while ($info = $result->fetch_assoc()) {
                                    $id = $info['id'];
                                    $name = $info['student_name'];
                                    $batch = $info['batch'];
                                    $department = $info['department'];
                                ?>
                                    <tr>
                                        <td><?php echo $id; ?></td>
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $batch; ?></td>
                                        <td><?php echo $department; ?></td>
                                    </tr>
                                <?php
                                } ?>


                            </tbody>
                        </table>

                    </div>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <div class="add">
                        <h3>Add Student</h3>
                        <br>
                        <?php
                        if (isset($_POST['add1'])) {
                            $name = $_POST['name'];
                            $pass = $_POST['password'];
                            $Batch = $_POST['batch'];
                            $department = $_POST['department'];
                            $check = 1;

                            $sql = "INSERT INTO student(batch,student_check, student_name, password,  department) VALUES('$Batch','$check', '$name', '$pass',  '$department')";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                echo ("<script>alert('Successfully!! Student Added')</script>");
                                echo ("<script>window.location = 'dashboard.php';</script>");
                                exit();
                            } else {
                                echo "<script>alert('Unsuccessfull!')</script>";
                                echo ("<script>window.location = 'dashboard.php';</script>");
                                exit();
                            }
                        }
                        ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="username">NAME</label>
                                <input type="text" id="username" name="name" class="form-control" required placeholder="Student ID">
                            </div>
                            <div class="form-group">
                                <label for="password">PASSWORD</label>
                                <input type="password" name="password" class="form-control " required placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="batch">BATCH</label>
                                <input type="text" name="batch" class="form-control " required placeholder="Batch">
                            </div>
                            <div class="form-group">
                                <label for="department">DEPARTMENT</label>
                                <input type="text" name="department" class="form-control " required placeholder="Department">
                            </div>
                            <br>
                            <button type="submit" name="add1" class="btn btn-primary">Add</button>
                        </form>

                    </div>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <div class="data">
                        <h3>Edit Student Information</h3>
                        <?php
                        if (isset($_POST['update1'])) {

                            $sql = "SELECT * FROM student WHERE student_check=1 ORDER BY id";
                            $result = mysqli_query($conn, $sql);
                            $row_count = mysqli_num_rows($result);

                            $x1 = 1;
                            $x2 = 111;
                            $x3 = 1111;
                            while ($row_count > 0 and $info = $result->fetch_assoc()) {
                                $id = $info['id'];
                                $name = $_POST[$x1];
                                $batch = $_POST[$x2];
                                $department = $_POST[$x3];
                                $sql1 = "UPDATE student SET student_name= '$name', batch='$batch', department='$department' WHERE id = '$id'";
                                $result1 = mysqli_query($conn, $sql1);
                                $x1++;
                                $x2++;
                                $x3++;
                                $row_count--;
                            }
                            if ($result) {
                                echo ("<script>alert('Successfully!! Student Details Updated')</script>");
                                echo ("<script>window.location = 'dashboard.php';</script>");
                                exit();
                            } else {
                                echo "<script>alert('Unsuccessfull!')</script>";
                                echo ("<script>window.location = 'dashboard.php';</script>");
                                exit();
                            }
                        }
                        ?>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Batch</th>
                                    <th>Department</th>
                                </tr>
                            </thead>
                            <tbody>

                                <form method="POST">
                                    <?php $sql = "SELECT * FROM student WHERE student_check=1 ORDER BY id";
                                    $result = mysqli_query($conn, $sql);
                                    $x1 = 1;
                                    $x2 = 111;
                                    $x3 = 1111;
                                    while ($info = $result->fetch_assoc()) {
                                        $id = $info['id'];
                                        $name = $info['student_name'];
                                        $batch = $info['batch'];
                                        $department = $info['department'];
                                    ?>
                                        <tr>
                                            <td><?php echo $id; ?></td>
                                            <td><input type="text" name="<?php echo $x1; ?>" value="<?php echo $name; ?>"></td>
                                            <td><input type="text" name="<?php echo $x2; ?>" value="<?php echo $batch; ?>"></td>
                                            <td><input type="text" name="<?php echo $x3; ?>" value="<?php echo $department; ?>"></td>
                                        </tr>
                                    <?php
                                        $x1++;
                                        $x2++;
                                        $x3++;
                                    } ?>

                            </tbody>
                        </table>
                        <input type="submit" class="btn btn-primary" name="update1" value="Update">
                        </form>
                    </div>
                </div>



                <!-- Delete Student -->
                <div id="menu3" class="tab-pane fade">
                    <div class="data">
                        <h3>Drop Student</h3>
                        <br>
                        <?php
                        if (isset($_POST['delete1'])) {
                            $id = $_POST['id'];
                            $sql1 = "UPDATE student SET student_check='0' WHERE id = '$id'";
                            $result1 = mysqli_query($conn, $sql1);
                            if ($result1) {
                                echo ("<script>alert('Successfully!! Student Drop')</script>");
                                echo ("<script>window.location = 'dashboard.php';</script>");
                                exit();
                            } else {
                                echo "<script>alert('Unsuccessfull!')</script>";
                                echo ("<script>window.location = 'dashboard.php';</script>");
                                exit();
                            }
                        }
                        ?>
                        <form method="POST" class="add">
                            <div class="form-group">
                                <label for="id">STUDENT ID</label>
                                <input type="text" name="id" class="form-control " required placeholder="Student ID">
                            </div>
                            <button type="submit" name="delete1" class="btn btn-primary">DROP</button>
                        </form>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Batch</th>
                                    <th>Department</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sql = "SELECT * FROM student WHERE student_check=1 ORDER BY id";
                                $result = mysqli_query($conn, $sql);

                                while ($info = $result->fetch_assoc()) {
                                    $id = $info['id'];
                                    $name = $info['student_name'];
                                    $batch = $info['batch'];
                                    $department = $info['department'];
                                ?>
                                    <tr>
                                        <td><?php echo $id; ?></td>
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $batch; ?></td>
                                        <td><?php echo $department; ?></td>
                                    </tr>
                                <?php
                                } ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
        </div>

    </body>

    </html>
<?php
} else {
    header("Location: login.php");
    exit();
}
?>