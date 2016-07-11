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
    header("Location: ../index.php");
} else {
    $logged = 'out';
    if (isset($_POST['username']) && isset($_POST['p'])) {
        $login->processLogin($_POST['username'], $_POST['p']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DeviousPs Login! | </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="css/custom.css" rel="stylesheet">
</head>

<body style="background:#F7F7F7;">
<center><a href="#">
        <div class="logo">
            <img style="width:44%" class="loginlogo" alt="Logo" src="images/logo.png">
        </div>
    </a></center>
<div class="">
    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>

    <div id="wrapper">
        <div id="login" class=" form">
            <section class="login_content">
                <form action="" method="POST">
                    <h1>Login Form</h1>
                    <div>
                        <input name="username" type="text" class="form-control" placeholder="Username" required=""/>
                    </div>
                    <div>
                        <input name="p" type="password" class="form-control" placeholder="Password" required=""/>
                    </div>
                    <div>

                        <input class="btn btn-default submit" value="Log In" type="submit"/>
                    </div>
                    <div class="clearfix"></div>

                    <div class="clearfix"></div>
                    <br/>
                    <div class="separator">
                        <div>

                            <p>©2016 All Rights Reserved DeviousPs </p>
                        </div>
                    </div>
                </form>
            </section>
        </div>

        <div id="register" class=" form">
            <section class="login_content">
                <form>
                    <h1>Create Account</h1>
                    <div>
                        <input type="text" class="form-control" placeholder="Username" required=""/>
                    </div>
                    <div>
                        <input type="email" class="form-control" placeholder="Email" required=""/>
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Password" required=""/>
                    </div>
                    <div>
                        <a class="btn btn-default submit" href="index.html">Submit</a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="separator">

                        <p class="change_link">Already a member ?
                            <a href="#tologin" class="to_register"> Log in </a>
                        </p>
                        <div class="clearfix"></div>
                        <br/>
                        <div>
                            <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Gentelella Alela!</h1>

                            <p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and
                                Terms</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
</body>
</html>