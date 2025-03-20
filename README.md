# ciss298-TeamProject
The website will automatically build here:
https://ciss298.zenren.xyz

# Snapshots
Weekly snapshots will be made for submission. They will be hosted on the site like:\
`https://ciss298.zenren.xyz/weekX`\
Direct links will be added below.
A new branch will be created to view the files code at the time of the snapshot.

# SQL Connection
In order to secure credentials in this repository, any php files interfacing with the SQL server must create a connection string using data stored in "/.env" Example:
```
$env = parse_ini_file(__DIR__ . "/.env");
$servername = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$dbname = $env['DB_NAME'];
$conn = new mysqli($servername, $username, $password, $dbname);
```
Should a PR be pushed without the correct connection string, verification will fail for the PR and propting you to change the files.

# SQL Layout
To ensure consistency between developement and production, use the following structure in your database:
```
DB NAME: hotel
```
