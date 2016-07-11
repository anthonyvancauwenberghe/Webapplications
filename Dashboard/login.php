<?php
/**
 * Copyright (C) 2013 peredur.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once '../libs/AutoLoader.php';

$login = new LoginSystem();

$login->sec_session_start();

if ($login->login_check()) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DeviousPs Logs</title>
    <link rel="stylesheet" href="styles/main.css" />
</head>
<body>
<center><h1>DeviousPs Logs</h1><br><br>
    <form action="test.php" method="GET" name="login_form">
        Username: <input type="text" name="username" />
        Password: <input type="password"
                         name="p"
                         id="password"/>
        <input type="submit"
               value="submit" />
    </form><br>
    <?php
    if (isset($_GET['error'])) {
        echo '<p class="error">Wrong Username or Password!</p>';
    }
    ?></center>


</body>
</html>