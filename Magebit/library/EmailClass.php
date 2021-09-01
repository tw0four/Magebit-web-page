<?php

class EmailClass
{
    private $id, $email_address, $date, $domain;
    private $table = "emails";
    private $error_message = "";


    function setId($id){
        $this->id=$id;
    }
    function getId(){
        return $this->id;
    }

    function setAddress($email_address){
        $this->email_address=$email_address;
    }
    function getAddress(){
        return $this->email_address;
    }

    function setDate($date){
        return $this->date=$date;
    }
    function getDate(){
        return $this->date;
    }

    function setDomain($domain){
        return $this->domain=$domain;
    }
    function getDomain(){
        return substr(strrchr($this->getAddress(), "@"), 1);
    }

    function getTable(){
        return $this->table;
    }

    public function insertEmail()
    {
        $database = new DataBase();
        $table = $this->getTable();

        $sql = "INSERT INTO $table(address, domain) VALUES('" . $this->getAddress() . "','".$this->getDomain()."')";
        $conn = $database->getConnection();
        $conn->query($sql);

        $conn->close();
    }

    function validation($error){
        $this->error_message = $error;
    }
    function printError(){
        return $this->error_message;
    }

    public function showEmails($result)
    {
        if($result != false && $result->num_rows > 0){
            $id = $this->getId();
            echo "<tr>
                <th id='checkbox'>
                <input type='checkbox' name='checkbox[]' class='delete-checkbox' value='$id'>
                </th>
                <th>".$this->getAddress()."</th>
                <th colspan='4'>".$this->getDate()."</th>
            </tr>";
        }
    }

    public function getEmails($sql)
    {
        $database = new DataBase();
        $conn = $database->getConnection();
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $this->setId($row['id']);
                $this->setAddress($row['address']);
                $this->setDate($row['date']);
                $this->setDomain($row['domain']);

                $this->showEmails($result);
            }
        }
        $conn->close();
    }

    public function getDomains($sql){

        $database = new DataBase();
        $conn = $database->getConnection();
        $result = $conn->query($sql);

        $array = array();

        if($result->num_rows > 0) {
            for($i=0; $i < $result->num_rows; $i++){
                $row = $result->fetch_assoc();
                $this->setAddress($row['address']);

                $domain = $this->getDomain();

                if($i == 0){
                    array_push($array, $domain);
                    $this->setAddress($row['address']);
                    $this->showDomains($result);
                }else{
                    if(in_array($domain, $array)){
                        array_push($array, $domain);
                    }else{
                        array_push($array, $domain);
                        $this->setAddress($row['address']);
                        $this->showDomains($result);
                    }
                }
            }
        }
    }

    public function showDomains($result){
        if($result !== false && $result->num_rows > 0){
            $domain = $this->getDomain();
            echo "<tr><th colspan='2'>
            <input type='checkbox' name='domain[]' value='$domain'>$domain
            </th></tr>";
        }
    }

    public function deleteEmails(){

        $database = new DataBase();
        $conn = $database->getConnection();
        $table = $this->getTable();

        foreach($_POST['checkbox'] as $id){
            $sql = "DELETE FROM $table WHERE id=".$id;
            $conn->query($sql);
        }
        $conn->close();
    }

    public function showEmailList(){
        if(isset($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && empty($_POST['by-email']) && empty($_POST['domain'])){
            $this->getEmails("SELECT * FROM $this->table ORDER BY address ASC");
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
                $this->getEmails("SELECT * FROM $this->table WHERE domain IN(".$sql.") ORDER BY address ASC");
                unset($_POST['by-name-asc']);
                unset($_POST['domain']);
            }else{
                if(empty($_POST['by-name-asc']) && isset($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && empty($_POST['by-email']) && empty($_POST['domain'])){
                    $this->getEmails("SELECT * FROM $this->table ORDER BY address DESC");
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
                        $this->getEmails("SELECT * FROM $this->table WHERE domain IN(".$sql.") ORDER BY address DESC");
                        unset($_POST['by-name-desc']);
                        unset($_POST['domain']);
                    }else{
                        if(empty($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && isset($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && empty($_POST['by-email']) && empty($_POST['domain'])){
                            $this->getEmails("SELECT * FROM $this->table ORDER BY date ASC");
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
                                $this->getEmails("SELECT * FROM $this->table WHERE domain IN(" . $sql . ") ORDER BY date ASC");
                                unset($_POST['by-date-asc']);
                                unset($_POST['domain']);
                            }else{
                                if(empty($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && isset($_POST['by-date-desc']) && empty($_POST['by-email']) && empty($_POST['domain'])){
                                    $this->getEmails("SELECT * FROM $this->table ORDER BY date DESC");
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
                                        $this->getEmails("SELECT * FROM $this->table WHERE domain IN(" . $sql . ") ORDER BY date DESC");
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
                                            $this->getEmails("SELECT * FROM $this->table WHERE domain IN(" . $sql . ")");
                                            unset($_POST['domain']);
                                        }else{
                                            if(empty($_POST['by-name-asc']) && empty($_POST['by-name-desc']) && empty($_POST['by-date-asc']) && empty($_POST['by-date-desc']) && isset($_POST['by-email']) && empty($_POST['domain'])){
                                                $this->getEmails("SELECT * FROM $this->table WHERE address ='" . $_POST['by-email'] . "'");
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
}
