<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary =$MobileNo= $DOB="";
$name_err = $address_err = $salary_err= $Mob_err=$DOB_err= "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }


    // Mobile No
    $input_mob = trim($_POST["MobileNo"]);
    if(empty($input_mob))
    {
        $Mob_err = "Please enter correct mobile no.";     
    } 
    elseif(!ctype_digit($input_mob))
    {
        $Mob_err = "Please enter a positive integer value.";
    } 
    else
    {
        $MobileNo = $input_mob;
    }

    // DOB
    $input_DOB = trim($_POST["DOB"]);
    if(empty($input_DOB))
    {
        $DOB_err = "Please enter correct date.";     
    } 
    else
    {
        $DOB = $input_DOB;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err) && empty($Mob_err) && empty($DOB_err))
    {
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary, MobileNo, DOB) VALUES (?, ?, ?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_address, $param_salary,$param_mob, $param_dob);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_mob= $MobileNo;
            $param_dob=$DOB;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } 
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>MobileNo</label>
                            <input type="number" name="MobileNo" class="form-control <?php echo (!empty($Mob_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $MobileNo; ?>">
                            <span class="invalid-feedback"><?php echo $Mob_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>DOB</label>
                            <input type="date" name="DOB" class="form-control <?php echo (!empty($DOB_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $DOB; ?>">
                            <span class="invalid-feedback"><?php echo $DOB_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>