<?php

class Template
{
    private $login;
    private $playerInfo;
    private $dashboard;
    private $scripts;
    private $core;
    private $name;

    public function __construct($login)
    {
        $this->login = $login;
        $this->name = $login->getName();
    }

    public function printPlayerDashboard()
    {
        echo '<div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Time Played</span>
              <div class="count">' . $this->getPlayerData()->getPlayTime() . ' days</div>
              <span class="count_bottom"><i class="green">' . $this->getPlayerData()->getPlaytimeThisWeekInHours($this->login->getName()) . ' </i>  Hours This Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-money"></i> GP Wealth</span>
              <div class="count">' . $this->getCore()->formatGP($this->getPlayerData()->getGPWealth()) . ' GP</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-usd"></i> DP Wealth</span>
              <div class="count green">' . round($this->getPlayerData()->getDPWealth() / 100, 2) . ' $</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-bullseye"></i> KDR</span>
              <div class="count">' . $this->getPlayerData()->getKdr() . '</div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-bar-chart"></i> Total Level</span>
              <div class="count">' . $this->getPlayerData()->getTotalLevel() . '</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>32 Levels Up </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-bar-chart"></i> Combat Level</span>
              <div class="count">' . $this->getPlayerData()->getCombatLevel() . '</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>5 Levels </i> From last Week</span>
            </div>
          </div>
          <!-- /top tiles -->

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>Wealth Graph </h3>
                  </div>
                  <div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                  </div>
                </div>

                <div id="wealth_graph" style="height: 400px; min-width: 310px"></div>
                

                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />

          <div class="row">';

        $this->getDashboard()->printTopPVMKills();
        $this->getDashboard()->printExperienceGained();
        $this->getDashboard()->printLatestDuels();

        echo '
          
              </div>
            </div>
          </div>
        </div>';
    }

    private function getPlayerData()
    {
        if (!isset($this->playerInfo)) {
            $this->playerInfo = new PlayerInfo("Plum 95");
        }
        return $this->playerInfo;
    }

    private function getCore()
    {
        if (!isset($this->core)) {
            $this->core = new Core();
        }
        return $this->core;
    }

    private function getDashboard()
    {
        if (!isset($this->dashboard)) {
            $this->dashboard = new Dashboard($this->getName());
        }
        return $this->dashboard;
    }

    /**
     * @return mixed
     */
    
    public function getName()
    {
        return $this->name;
    }

    public function printDashboardScripts()
    {
        echo "<!-- jQuery -->
<script src='vendors/jquery/dist/jquery.min.js'></script>
<!-- Bootstrap -->
<script src='vendors/bootstrap/dist/js/bootstrap.min.js'></script>
<!-- FastClick -->
<script src='vendors/fastclick/lib/fastclick.js'></script>
<!-- NProgress -->
<script src='vendors/nprogress/nprogress.js'></script>
<!-- Chart.js -->
<script src='../vendors/Chart.js/dist/Chart.min.js'></script>
<!-- gauge.js -->
<script src='../vendors/gauge.js/dist/gauge.min.js'></script>
<!-- bootstrap-progressbar -->
<script src='../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'></script>
<!-- iCheck -->
<script src='../vendors/iCheck/icheck.min.js'></script>
<!-- Skycons -->
<script src='../vendors/skycons/skycons.js'></script>
<!-- Flot -->
<script src='../vendors/Flot/jquery.flot.js'></script>
<script src='../vendors/Flot/jquery.flot.pie.js'></script>
<script src='../vendors/Flot/jquery.flot.time.js'></script>
<script src='../vendors/Flot/jquery.flot.stack.js'></script>
<script src='../vendors/Flot/jquery.flot.resize.js'></script>
<!-- Flot plugins -->
<script src='js/flot/jquery.flot.orderBars.js'></script>
<script src='js/flot/date.js'></script>
<script src='js/flot/jquery.flot.spline.js'></script>
<script src='js/flot/curvedLines.js'></script>
<!-- JQVMap -->
<script src='../vendors/jqvmap/dist/jquery.vmap.js'></script>
<script src='../vendors/jqvmap/dist/maps/jquery.vmap.world.js'></script>
<script src='../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js'></script>
<!-- bootstrap-daterangepicker -->
<script src='js/moment/moment.min.js'></script>
<script src='js/datepicker/daterangepicker.js'></script>

<!-- Custom Theme Scripts -->
<script src='js/custom.js'></script>

<!-- Flot -->
<script>
    $(document).ready(function() {
        var data1 = [
            [gd(2012, 1, 1), 17],
            [gd(2012, 1, 2), 74],
            [gd(2012, 1, 3), 6],
            [gd(2012, 1, 4), 39],
            [gd(2012, 1, 5), 20],
            [gd(2012, 1, 6), 85],
            [gd(2012, 1, 7), 7]
        ];

        var data2 = [
            [gd(2012, 1, 1), 82],
            [gd(2012, 1, 2), 23],
            [gd(2012, 1, 3), 66],
            [gd(2012, 1, 4), 9],
            [gd(2012, 1, 5), 119],
            [gd(2012, 1, 6), 6],
            [gd(2012, 1, 7), 9]
        ];
        $('#canvas_dahs').length && $.plot($('#canvas_dahs'), [
            data1, data2
        ], {
            series: {
                lines: {
                    show: false,
                    fill: true
                },
                splines: {
                    show: true,
                    tension: 0.4,
                    lineWidth: 1,
                    fill: 0.4
                },
                points: {
                    radius: 0,
                    show: true
                },
                shadowSize: 2
            },
            grid: {
                verticalLines: true,
                hoverable: true,
                clickable: true,
                tickColor: '#d5d5d5',
                borderWidth: 1,
                color: '#fff'
            },
            colors: ['rgba(38, 185, 154, 0.38)', 'rgba(3, 88, 106, 0.38)'],
            xaxis: {
                tickColor: 'rgba(51, 51, 51, 0.06)',
                mode: 'time',
                tickSize: [1, 'day'],
                //tickLength: 10,
                axisLabel: 'Date',
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10
            },
            yaxis: {
                ticks: 8,
                tickColor: 'rgba(51, 51, 51, 0.06)',
            },
            tooltip: false
        });

        function gd(year, month, day) {
            return new Date(year, month - 1, day).getTime();
        }
    });
</script>
<!-- /Flot -->

<!-- JQVMap -->
<script>
    $(document).ready(function(){
        $('#world-map-gdp').vectorMap({
            map: 'world_en',
            backgroundColor: null,
            color: '#ffffff',
            hoverOpacity: 0.7,
            selectedColor: '#666666',
            enableZoom: true,
            showTooltip: true,
            values: sample_data,
            scaleColors: ['#E6F2F0', '#149B7E'],
            normalizeFunction: 'polynomial'
        });
    });
</script>
<!-- /JQVMap -->

<!-- Skycons -->
<script>
    $(document).ready(function() {
        var icons = new Skycons({
                'color': '#73879C'
            }),
            list = [
                'clear-day', 'clear-night', 'partly-cloudy-day',
                'partly-cloudy-night', 'cloudy', 'rain', 'sleet', 'snow', 'wind',
                'fog'
            ],
            i;

        for (i = list.length; i--;)
            icons.set(list[i], list[i]);

        icons.play();
    });
</script>
<!-- /Skycons -->

<!-- bootstrap-daterangepicker -->
<script>
    $(document).ready(function() {

        var cb = function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2012',
            maxDate: '12/31/2015',
            dateLimit: {
                days: 60
            },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-small btn-primary',
            cancelClass: 'btn-small',
            format: 'MM/DD/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Clear',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        };
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
            console.log('show event fired');
        });
        $('#reportrange').on('hide.daterangepicker', function() {
            console.log('hide event fired');
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            console.log('apply event fired, start/end dates are ' + picker.startDate.format('MMMM D, YYYY') + ' to ' + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
            console.log('cancel event fired');
        });
        $('#options1').click(function() {
            $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
            $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
            $('#reportrange').data('daterangepicker').remove();
        });
    });
</script>
<!-- /bootstrap-daterangepicker -->

<!-- gauge.js -->
<script>
    var opts = {
        lines: 12,
        angle: 0,
        lineWidth: 0.4,
        pointer: {
            length: 0.75,
            strokeWidth: 0.042,
            color: '#1D212A'
        },
        limitMax: 'false',
        colorStart: '#1ABC9C',
        colorStop: '#1ABC9C',
        strokeColor: '#F0F3F3',
        generateGradient: true
    };
    var target = document.getElementById('foo'),
        gauge = new Gauge(target).setOptions(opts);

    gauge.maxValue = 6000;
    gauge.animationSpeed = 32;
    gauge.set(3200);
    gauge.setTextField(document.getElementById('gauge-text'));
</script>
<!-- /gauge.js -->

<script src='../js/highstock/highstock.js'></script>
<script src='../js/highstock/modules/exporting.js'></script>";
        $this->getScripts()->printWealthGraphScript($this->getPlayerData()->getGPWealthData(), $this->getPlayerData()->getDPWealthData());
    }

    private function getScripts()
    {

        if (!isset($this->scripts)) {
            $this->scripts = new Scripts();
        }
        return $this->scripts;
    }

    public function printSidebar()
    {
        echo '<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>' . ucfirst($this->login->getRankName()) . '</h3>
                                <ul class="nav side-menu">';

        echo '<li><a href="../index.php"><i class="fa fa-home"></i> Home</a>
                                    </li>';

        echo '<li><a href="../votes.php"><i class="fa fa-check-square-o"></i> Votes</a>
                                    </li>';

        echo '<li><a href="../donations.php"><i class="fa fa-usd"></i> Donations</a>
                                    </li>';

        echo '<li><a href="../drops.php"><i class="fa fa-bug"></i> Drops</a>
                                    </li>';

        if ($this->login->hasPermission(Rank::MODERATOR)) {
            echo '<li><a href="../logs.php"><i class="fa fa-bar-chart-o"></i> Logs</a>
                                    </li>';
        }

        if ($this->login->hasPermission(Rank::HEAD_MODERATOR)) {
            echo '<li><a href="../admin/index.php"><i class="fa fa-desktop"></i> Admin Panel</a>
                                    </li>';
        }


        echo '</ul>
                    </div>
              </div>';
    }

    public function printTopNavigation()
    {
        echo '<div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="images/img.png" alt="">' . ucfirst($this->login->getName()) . '
<span class=" fa fa-angle-down"></span>
</a>
<ul class="dropdown-menu dropdown-usermenu pull-right">
    <li><a href="#"> Profile</a></li>
    <li><a href="#"> Change Password</a></li>
    <li><a href="../index.php?logout=true"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
</ul>
</li>


 

</ul>
</nav>
</div>
</div>';
    }

    public function printFooterButtons()
    {
        echo '<div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout" href="../index.php/?logout=true">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>';
    }

    public function printPageTitle($title)
    {
        echo '<div class="title_left">
                        <h3>' . $title . '</h3>
                  </div>';
    }

    public function printLogsSearchBar()
    {
        echo '<div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input id="searchform" type="text" class="form-control" placeholder="Search for...">


                                <span class="input-group-btn">
                      <div class="btn-group open">
                                    <button id="logTypeButton" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="true"> <span id="type">Log Type</span> </button>
                                    <ul id="loglist" class="dropdown-menu">
                                        <li id="death"><a>Death Logs</a>
                                        </li>
                                        <li id="trade"><a>Trade Logs</a>
                                        </li>
                                        <li id="duel"><a>Duel Logs</a>
                                        </li>
                                        <li id="pickup-item"><a>Pickup-Item Logs</a>
                                        </li>
                                        <li id="kill"><a>Kill Logs</a>
                                        </li>
                                        <li id="drop-item"><a>Drop-Item Logs</a>
                                        </li>
                                        <li id="public-chat"><a>Public Chat Logs</a>
                                        </li>
                                        <li id="private-chat"><a>Private Chat Logs</a>
                                        </li>
                                        <li id="clan-chat"><a>Clan Chat Logs</a>
                                        </li>
                                        <li id="accountvalues"><a>Accountvalue Logs</a>
                                        </li>
                                    </ul>
                                </div>
                                  <button id="searchButton" class="btn btn-default" type="button">Search</button>
                    </span>
                            </div>
                        </div>
                    </div>';
    }

    public function printMenuProfile()
    {
        echo '<div class="profile">
                    <div class="profile_pic">
                        <img src="images/img.png" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>' . ucfirst($this->login->getName()) . '</h2>
                    </div>
                </div>';
    }

    private function printMessageTemplate()
    {
        echo '<li role="presentation" class="dropdown">
<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-envelope-o"></i>
        <span class="badge bg-green">6</span>
    </a>
    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
        <li>
            <a>
                <span class="image"><img src="images/img.png" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
            </a>
        </li>
        <li>
            <a>
                <span class="image"><img src="images/img.png" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
            </a>
        </li>
        <li>
            <a>
                <span class="image"><img src="images/img.png" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
            </a>
        </li>
        <li>
            <a>
                <span class="image"><img src="images/img.png" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
            </a>
        </li>
        <li>
            <div class="text-center">
                <a>
                    <strong>See All Alerts</strong>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </li>
    </ul>
    </li>';
    }
}