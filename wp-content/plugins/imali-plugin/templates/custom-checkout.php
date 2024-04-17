    <?php
    // Database connection
    global $wpdb;
    $servername = "localhost";
    $username = "mamp";
    $password = "Litmus$8552";
    $dbname = "wordpress";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    echo "Connected successfully";

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if form is submitted
    if (isset($_POST['submit'])) {
        // Capture form data
        $country = $_POST['countries'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $company = $_POST['company'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];

        // Sanitize data
        $country = mysqli_real_escape_string($conn, $country);
        $fname = mysqli_real_escape_string($conn, $fname);
        $lname = mysqli_real_escape_string($conn, $lname);
        $company = mysqli_real_escape_string($conn, $company);
        $address = mysqli_real_escape_string($conn, $address);
        $city = mysqli_real_escape_string($conn, $city);
        $email = mysqli_real_escape_string($conn, $email);
        $tel = mysqli_real_escape_string($conn, $tel);

        // SQL query to create the table
        $sql = "CREATE TABLE IF NOT EXISTS billing_details (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            country VARCHAR(255) NOT NULL,
            fname VARCHAR(255) NOT NULL,
            lname VARCHAR(255) NOT NULL,
            company VARCHAR(255) NOT NULL,
            address VARCHAR(255) NOT NULL,
            city VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            tel VARCHAR(20) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        // Execute query
        if ($conn->query($sql) === TRUE) {
            echo "Table billing_details created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }


        // Insert data into database
        $sql = "INSERT INTO billing_details (country, fname, lname, company, address, city, email, tel)
        VALUES ('$country', '$fname', '$lname', '$company', '$address', '$city', '$email', '$tel')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close connection
    $conn->close();

