function generateData() {
   var maturityLevel1 = document.getElementById('maturityLevel').value;
   var maturityScore1 = document.getElementById('maturityScore').value;
   var LOB = document.getElementById('LOBid').value;

   // Create the SQL query string
  var sqlQuery = "INSERT INTO Maturity (LOB, MaturityLevel, MaturityScore) VALUES ('" + LOB + "', '" + maturityLevel1 + "', '" + maturityScore1 + "');";

   // Send the SQL query to the server
    var xhr = new XMLHttpRequest();
    // xhr.open("POST", "Path to execute_sql_SSH.php", true);
 xhr.open("POST", "execute_sql_SSH.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Success message
                console.log("generateData triggred" + xhr.responseText);
            } else {
                // Error message
                console.error("Error executing SQL query: " + xhr.responseText);

            }
        }
    };

    xhr.send("sqlQuery=" + encodeURIComponent(sqlQuery));
}
