# ciss298-TeamProject
The website will automatically build here:
https://ciss298.zenren.xyz

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
