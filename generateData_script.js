// Import the snowflake-sdk library
const snowflake = require('snowflake-sdk');

function generateData() {
    var maturityLevel1 = document.getElementById('maturityLevel').value;
    var maturityScore1 = document.getElementById('maturityScore').value;
    var LOB = document.getElementById('LOBid').value;

    // Create a connection object with Snowflake credentials
    const connection = snowflake.createConnection({
        account: 'your_account_name',
        username: 'your_username',
        password: 'your_password',
        database: 'your_database_name',
        warehouse: 'your_warehouse_name',
        role: 'your_role_name',
        region: 'your_snowflake_region' // e.g., 'us-west-2'
    });

    // Connect to Snowflake
    connection.connect((err, conn) => {
        if (err) {
            console.error('Error connecting to Snowflake: ', err);
            return;
        }

        console.log('Connected to Snowflake.');

        // Create the SQL query string
        var sqlQuery = `INSERT INTO Maturity (LOB, MaturityLevel, MaturityScore)
                        VALUES ('${LOB}', '${maturityLevel1}', ${maturityScore1});`;

        // Execute the SQL query
        conn.execute({
            sqlText: sqlQuery,
            complete: (err, stmt, rows) => {
                if (err) {
                    console.error('Error executing SQL query: ', err);
                } else {
                    console.log('Data inserted successfully.');
                }

                // Close the connection after query execution
                conn.destroy();
            }
        });
    });
}
