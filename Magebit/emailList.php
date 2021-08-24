<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email List</title>
    <style>
        body{
            height: 100%;
        }
        .container{
            position: absolute;
            height: 100%;
            min-height: 600px;
            width: 75%;
            left: 15.5%;
            top: 10%;
            border: 2px solid black;
        }
        table{
            position: absolute;
            left: 5%;
        }

        th{
            min-width: 60px;
            border: 1px solid black;
            height: 20px;
        }

        .lines{
            height: 20px;
        }

        #sort-table{
            position: absolute;
            top: 15%;
        }
        .submit-button{
            width: 40px;
            height: 20px;
        }
        .delete-btn{
            width: 60px;
            height: 20px;
        }

    </style>
</head>
<body>


<div class="container">
    <table id="sort-table">
        <form method="post">
        <tr class="lines">
            <th><input type="checkbox" name="by-name-asc" <?php if(isset($_POST['by-name-asc'])) echo "checked='checked'"; ?>>By Name ASC</th>
            <th><input type="checkbox" name="by-name-desc" <?php if(isset($_POST['by-name-desc'])) echo "checked='checked'"; ?>>By Name DESC</th>
            <th><input type="checkbox" name="by-date-asc"> <?php if(isset($_POST['by-date-asc'])) echo "checked='checked'"; ?>By Date ASC</th>
            <th><input type="checkbox" name="by-date-desc" <?php if(isset($_POST['by-date-desc'])) echo "checked='checked'"; ?>>By Date DESC</th>
            <th><button type="submit" class="submit-button" name="submit" formaction="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"></button> Submit</th>
            <th><button type="submit" class="delete-btn" name="delete" formaction=" ">DEL</button></th>
        </tr>
            <tr>
                <th colspan="6">
                    <input type="text" name="by-email" placeholder="Enter email">By Email
                </th>
            </tr>
                <?php
                spl_autoload_register(function($class){
                    require_once ('library/'.$class.'.php');
                });

                $email = new EmailClass();

                $table = $email->getTable();
                $email->getDomains("SELECT * FROM $table");

                if(isset($_POST['delete'])){
                    $email->deleteEmails();
                }

                if (isset($_POST['submit'])){
                    $email->showEmailList();
                }

            ?>
        </form>
    </table>
</div>
</body>
</html>
