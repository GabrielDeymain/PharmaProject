<?php
class PharmacyDatabase {
    private $host = "localhost";
    private $port = "3306";
    private $database = "pharmacy_portal_db";
    private $user = "root";
    private $password = "NewPassword";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        echo "Successfully connected to the database";
    }

    public function addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity)  {
        $stmt = $this->connection->prepare(
            "SELECT userId FROM Users WHERE userName = ? AND userType = 'patient'"
        );
        $stmt->bind_param("s", $patientUserName);
        $stmt->execute();
        $stmt->bind_result($patientId);
        $stmt->fetch();
        $stmt->close();
        
        if ($patientId){
            $stmt = $this->connection->prepare(
                "INSERT INTO prescriptions (userId, medicationId, dosageInstructions, quantity) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("iisi", $patientId, $medicationId, $dosageInstructions, $quantity);
            $stmt->execute();
            $stmt->close();
            echo "Prescription added successfully";
        }else{
            echo "failed to add prescription";
        }
    }

    public function getAllPrescriptions() {
        $result = $this->connection->query("SELECT * FROM  prescriptions join medications on prescriptions.medicationId= medications.medicationId");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function MedicationInventory() {
        $sql = "select * from medication";
        $result = $this->connection->query($sql);
        echo"<h2>Inventory</h2>";
        echo"<table order='1'><tr><th>inventoryID</th><th>medicationID</th><th>Quantity Available</th><th>Last Updated</th>";
        if($result->num_rows > 0){
            while ($row = $resuilt->fetch_assoc()){
                echo "<tr><td>{$row['inventoryID']}</td><td>{$row['medicationID']}</td><td>{$row['Quantity Available']}</td><td>{$row['Last Updated']}</td></tr>";
            } 
            } else {
                echo "<tr><td colspan='4'>N/A</td></tr>";

            }
            echo "</table>";
        }
    }

    public function addUser($userName, $contactInfo, $userType) {
        $sql = "INSERT INTO Users (userName, contactInfo, userType) VALUES (?, ?, ?)";
        $stmt = $this->$connection->prepare($sql);
        $stmt->bind_param("sss", $userName, $contactInfo, $userType);

        if ($stmt->execute()) {
        echo "User added successfully!";
        } else {
        echo "Error: " . $stmt->error;
        }


        $stmt->close();
    }

    public function __destruct() {
            $this->$connection->close();
    }
}
?>   
