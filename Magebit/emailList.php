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
            <th><button type="submit" class="submit-button" name="submit" formaction="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" m></button> Submit</th>
            <th><button type="submit" class="delete-btn" name="delete" formaction="deleteEmails.php">DEL</button></th>
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
                    $database = new DataBase();
                    $table = $database->getTable();

                    $domain = new EmailClass();
                    $domain->getDomains("SELECT * FROM $table");
                ?>

            <?php
            $email = new EmailClass();
            if (isset($_POST['submit'])){
                if(isset($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && empty($_POST['by-email']) && empty($_POST['domain'])){
                    $email->getEmails("SELECT * FROM $table ORDER BY address ASC");
                    unset($_POST['by-name-asc']);
                }else{
                    if(isset($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && empty($_POST['by-email']) && isset($_POST['domain'])){
                        $i = 0;
                        $sql = "";
                        if(count($_POST['domain']) == 1){
                            foreach ($_POST['domain'] as $value){
                                $sql .= '"'.$value.'"';
                            }
                        }else{
                            foreach ($_POST['domain'] as $value){
                                $i++;
                                if($i == count($_POST['domain'])){
                                    $sql .= '"'.$value.'"';
                                }else if($i < count($_POST['domain'])){
                                    $sql .= '"'.$value.'"'.' , ';
                                }
                            }
                        }
                        $email->getEmails("SELECT * FROM $table WHERE domain IN(".$sql.") ORDER BY address ASC");
                        unset($_POST['by-name-asc']);
                        unset($_POST['domain']);
                    }else{
                        if(empty($_POST['by-name-asc']) && isset($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && empty($_POST['by-email']) && empty($_POST['domain'])){
                            $email->getEmails("SELECT * FROM $table ORDER BY address DESC");
                            unset($_POST['by-name-desc']);
                        }else{
                            if(empty($_POST['by-name-asc']) && isset($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && empty($_POST['by-email']) && isset($_POST['domain'])){
                                $i = 0;
                                $sql = "";
                                if(count($_POST['domain']) == 1){
                                    foreach ($_POST['domain'] as $value){
                                        $sql .= '"'.$value.'"';
                                    }
                                }else{
                                    foreach ($_POST['domain'] as $value){
                                        $i++;
                                        if($i == count($_POST['domain'])){
                                            $sql .= '"'.$value.'"';
                                        }else if($i < count($_POST['domain'])){
                                            $sql .= '"'.$value.'"'.' , ';
                                        }
                                    }
                                }
                                $email->getEmails("SELECT * FROM $table WHERE domain IN(".$sql.") ORDER BY address DESC");
                                unset($_POST['by-name-desc']);
                                unset($_POST['domain']);
                            }else{
                                if(empty($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && isset($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && empty($_POST['by-email']) && empty($_POST['domain'])){
                                    $email->getEmails("SELECT * FROM $table ORDER BY date ASC");
                                    unset($_POST['by-date-asc']);
                                }else {
                                    if (empty($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && isset($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && empty($_POST['by-email']) && isset($_POST['domain'])) {
                                        $i = 0;
                                        $sql = "";
                                        if (count($_POST['domain']) == 1) {
                                            foreach ($_POST['domain'] as $value) {
                                                $sql .= '"'.$value.'"';
                                            }
                                        } else {
                                            foreach ($_POST['domain'] as $value) {
                                                $i++;
                                                if ($i == count($_POST['domain'])) {
                                                    $sql .= '"' . $value . '"';
                                                } else if ($i < count($_POST['domain'])) {
                                                    $sql .= '"' . $value . '"' . ' , ';
                                                }
                                            }
                                        }
                                        $email->getEmails("SELECT * FROM $table WHERE domain IN(" . $sql . ") ORDER BY date ASC");
                                        unset($_POST['by-date-asc']);
                                        unset($_POST['domain']);
                                    }else{
                                        if(empty($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && isset($_POST['by-date-desc']) && empty($_POST['by-email']) && empty($_POST['domain'])){
                                            $email->getEmails("SELECT * FROM $table ORDER BY date DESC");
                                            unset($_POST['by-date-desc']);
                                        }else {
                                            if (empty($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && isset($_POST['by-date-desc']) && empty($_POST['by-email']) && isset($_POST['domain'])) {
                                                $i = 0;
                                                $sql = "";
                                                if (count($_POST['domain']) == 1) {
                                                    foreach ($_POST['domain'] as $value) {
                                                        $sql .= '"'.$value.'"';
                                                    }
                                                } else {
                                                    foreach ($_POST['domain'] as $value) {
                                                        $i++;
                                                        if ($i == count($_POST['domain'])) {
                                                            $sql .= '"' . $value . '"';
                                                        } else if ($i < count($_POST['domain'])) {
                                                            $sql .= '"' . $value . '"' . ' , ';
                                                        }
                                                    }
                                                }
                                                $email->getEmails("SELECT * FROM $table WHERE domain IN(" . $sql . ") ORDER BY date DESC");
                                                unset($_POST['by-date-desc']);
                                                unset($_POST['domain']);
                                            }else{
                                                if(empty($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && empty($_POST['by-email']) && isset($_POST['domain'])){
                                                    $i = 0;
                                                    $sql = "";
                                                    if (count($_POST['domain']) == 1) {
                                                        foreach ($_POST['domain'] as $value) {
                                                            $sql .= '"'.$value.'"';
                                                        }
                                                    } else {
                                                        foreach ($_POST['domain'] as $value) {
                                                            $i++;
                                                            if ($i == count($_POST['domain'])) {
                                                                $sql .= '"' . $value . '"';
                                                            } else if ($i < count($_POST['domain'])) {
                                                                $sql .= '"' . $value . '"' . ' , ';
                                                            }
                                                        }
                                                    }
                                                    $email->getEmails("SELECT * FROM $table WHERE domain IN(" . $sql . ")");
                                                    unset($_POST['domain']);
                                                }else{
                                                    if(empty($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && isset($_POST['by-email']) && empty($_POST['domain'])){
                                                        $email->getEmails("SELECT * FROM $table WHERE address ='" . $_POST['by-email'] . "'");
                                                        unset($_POST['by-email']);
                                                    }else{
                                                        echo "Unable to filter";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            ?>
        </form>
    </table>
</div>
</body>
</html>
