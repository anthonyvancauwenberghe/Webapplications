<?php

class Template
{

    public function printSidebar($login)
    {
        echo '<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>' . ucfirst($login->getRank()) . '</h3>
                                <ul class="nav side-menu">
                                    <li><a href="../index.php"><i class="fa fa-home"></i> Home</a>
                                    </li>
                                    <li><a href="../logs.php"><i class="fa fa-bar-chart-o"></i> Logs</a>
                                    </li>
                                    <li><a href="../drops.php"><i class="fa fa-bug"></i> Drops</a>
                                    </li>
                                </ul>
                    </div>
              </div>';
    }

}