<?php

class EmailClass
{
    private $id;
    private $email_address;
    private $date;
    private $domain;

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


    public function insertEmail()
    {
        $database = new DataBase();
        $table = $database->getTable();

        $sql = "INSERT INTO $table(address, domain) VALUES('" . $this->getAddress() . "','".$this->getDomain()."')";
        $conn = $database->getConnection();
        $conn->query($sql);

        $conn->close();
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
}
