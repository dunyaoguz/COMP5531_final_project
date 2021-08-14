<?php
    include_once('../../database.php');
    //session_start();

    //$user_id = $_SESSION['userId'];
    $user_id = "4";

    $canPostJob = FALSE;

    // Obtain Recruiter's Name, Recruiter ID, Recruiter's Employer ID
    $getRecruiterInfoStmt = $conn->prepare("SELECT * FROM recruiters WHERE user_id = :user_id");
    $getRecruiterInfoStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $getRecruiterInfoStmt->execute();
    $recruiterInfo = $getRecruiterInfoStmt->fetch();
    $recruiterName = $recruiterInfo['first_name'];
    $recruiterId = $recruiterInfo['id'];
    $recruiterEmployerId = $recruiterInfo['employer_id'];

    // Obtain Recruiter ID -> Obtain all Jobs for the Recruiter

    $getJobListingStmt = $conn->prepare("SELECT * FROM jobs WHERE recruiter_id = :recruiter_id");
    $getJobListingStmt->bindParam(':recruiter_id', $recruiterId, PDO::PARAM_INT);
    $getJobListingStmt->execute();

    // Obtain Membership ID of Employer -> fetch the Employer's membership Type

    $getEmployerMembershipIdStmt = $conn->prepare("SELECT * FROM employers WHERE user_id = :user_id");
    $getEmployerMembershipIdStmt->bindParam(':user_id', $recruiterEmployerId, PDO::PARAM_INT);
    $getEmployerMembershipIdStmt->execute();
    $getEmployerMembershipId = $getEmployerMembershipIdStmt->fetch()['membership_id'];

    $getEmployerMembershipInfoStmt = $conn->prepare("SELECT * FROM transactions WHERE id = :id");
    $getEmployerMembershipInfoStmt->bindParam(':id', $getEmployerMembershipId, PDO::PARAM_INT);
    $getEmployerMembershipInfoStmt->execute();
    $getEmployerMembershipInfo = $getEmployerMembershipInfoStmt->fetch()['membership_type'];

    // Get Total Number of Jobs For Employer

    $getTotalNumberOfJobsStmt = $conn->prepare("SELECT COUNT(id) FROM jobs WHERE employer_id = :employer_id");
    $getTotalNumberOfJobsStmt->bindParam(':employer_id', $recruiterEmployerId, PDO::PARAM_INT);
    $getTotalNumberOfJobsStmt->execute();
    $getTotalNumberOfJobs = $getTotalNumberOfJobsStmt->fetchColumn();

    // Check if the total jobs exceed or not

    if('Basic' == $getEmployerMembershipInfo && (int)$getTotalNumberOfJobs < 5){
        echo "<h4> Inside 1st if block </h4> <br>"; 
        $canPostJob = TRUE;
    }else if ('Gold' == $getEmployerMembershipInfo){
        echo "<h4> Inside 2st if block </h4> <br>"; 
        $canPostJob = TRUE;
    }else{
        echo "<h4> Inside else block </h4> <br>"; 
        $canPostJob = FALSE;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Recruiter Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../logo.png" type="penguin">
        <html lang="en">
    </head>
    <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">DAJ Recruitment Platform</span>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-item nav-link active" href="#">Dashboard<span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="#">Membership</a>
            <a class="nav-item nav-link" href="#">Contact Us</a>
          </div>
        </div>
        <span class="logo-image"><img src="../../logo.png" class="logo"></span>
        </div>
      </nav>
      <h1><?php echo $recruiterName . "'s Dashboard";?></h1>
      <h2>Your Jobs</h2>
      <h6>Here is a quick glance of all the jobs you've published with us.</h6>
      <br>
      <table class="table table-striped">
          <thead>
              <tr>
                  <td>Job ID</td>
                  <td>Date Posted</td>
                  <td>Job Title</td>
                  <td>Description</td>
                  <td>Required Experience (Years)</td>
                  <td>Status</td>
                  <td>Actions</td>
              </tr>
          </thead>

          <tbody>
              <?php while ($row = $getJobListingStmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { ?>
                  <tr>
                  <td> <?php echo $row['id']; ?> </td>
                  <td> <?php echo $row['date_posted']; ?> </td>
                  <td> <?php echo $row['title']; ?> </td>
                  <td> <?php echo $row['description']; ?> </td>
                  <td> <?php echo $row['required_experience']; ?> </td>
                  <td> <?php echo $row['status']; ?> </td>
                  <td>
                    <a href="./edit.php?job_id=<?= $row["id"] ?>">Edit</a><br>    
                    <a href="./delete.php?job_id=<?= $row["id"] ?>">Delete</a>
                  </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
      <br>
        <?php 
            if($canPostJob){ ?>
                <center><a href="./create.php" class="btn btn-outline-success">Add a New Job</a></center>
            <?php   } else {?>
                <center><a href="./index.php" class="btn btn-outline-success">Limit Reached: Can't Post New Jobs</a></center>
                <?php   }?>
      <br>
      <div class="footer">
        © 2021 Copyright: Dunya Oguz, Azman Akhter, John Purcell
      </div>

    </body>
</html>
