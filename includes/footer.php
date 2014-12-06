    </div><!-- .container-fluid -->
</div><!-- dashboard-container -->

<footer>
    <p>&copy; baswaAdmin 2013</p>
</footer>
<script src="<?=ADMIN_CSS_URL?>/js/wysiwyg/wysihtml5-0.3.0.js"></script>
<script src="<?=ADMIN_CSS_URL?>/js/jquery.min.js"></script>
<script src="<?=ADMIN_CSS_URL?>/js/bootstrap.js"></script>
<script src="<?=ADMIN_CSS_URL?>/js/wysiwyg/bootstrap-wysihtml5.js"></script>
<script src="<?=ADMIN_CSS_URL?>/js/jquery.scrollUp.js"></script>

<!-- Google Visualization JS -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<!-- Easy Pie Chart JS -->
<script src="<?=ADMIN_CSS_URL?>/js/jquery.easy-pie-chart.js"></script>

<!-- Sparkline JS -->
<script src="<?=ADMIN_CSS_URL?>/js/jquery.sparkline.js"></script>

<!-- Tiny Scrollbar JS -->
<script src="<?=ADMIN_CSS_URL?>/js/tiny-scrollbar.js"></script>


<script type="text/javascript">
    //ScrollUp
    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            topDistance: '300', // Distance from top before showing element (px)
            topSpeed: 300, // Speed back to top (ms)
            animation: 'fade', // Fade, slide, none
            animationInSpeed: 400, // Animation in speed (ms)
            animationOutSpeed: 400, // Animation out speed (ms)
            scrollText: 'Scroll to top', // Text for element
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        });
    });

    //Google Visualiations
    google.load("visualization", "1", {
        packages: ["corechart"]
    });
    google.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Week', 'Visitors', 'Orders'],
            ['Sun', 9709, 761],
            ['Mon', 1367, 8631],
            ['Tue', 6792, 971],
            ['Wed', 1267, 7491],
            ['Thu', 9539, 1792],
            ['Fri', 670, 9367],
            ['Sat', 9761, 709]
        ]);

        var options = {
            width: 'auto',
            height: '160',
            backgroundColor: 'transparent',
            colors: ['#ed6d49', '#0daed3'],
            tooltip: {
                textStyle: {
                    color: '#666666',
                    fontSize: 11
                },
                showColorCode: true
            },
            legend: {
                textStyle: {
                    color: 'black',
                    fontSize: 12
                }
            },
            chartArea: {
                left: 100,
                top: 10
            },
            focusTarget: 'category',
            hAxis: {
                textStyle: {
                    color: 'black',
                    fontSize: 12
                }
            },
            vAxis: {
                textStyle: {
                    color: 'black',
                    fontSize: 12
                }
            },
            pointSize: 6,
            chartArea: {
                left: 60,
                top: 10,
                height: '80%'
            },
            lineWidth: 1,
        };

        var chart = new google.visualization.LineChart(document.getElementById('area_chart'));
        chart.draw(data, options);
    }


    //Tooltip
    $('a').tooltip('hide');
    $('i').tooltip('hide');


    //Tiny Scrollbar
    $('#scrollbar').tinyscrollbar();
    $('#scrollbar-one').tinyscrollbar();
    $('#scrollbar-two').tinyscrollbar();
    $('#scrollbar-three').tinyscrollbar();


    //Tabs
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })

    // SparkLine Graphs-Charts
    $(function () {
        $('#unique-visitors').sparkline('html', {
            type: 'bar',
            barColor: '#ed6d49',
            barWidth: 6,
            height: 30,
        });
        $('#monthly-sales').sparkline('html', {
            type: 'bar',
            barColor: '#74b749',
            barWidth: 6,
            height: 30,
        });
        $('#current-balance').sparkline('html', {
            type: 'bar',
            barColor: '#ffb400',
            barWidth: 6,
            height: 30,
        });
        $('#registrations').sparkline('html', {
            type: 'bar',
            barColor: '#0daed3',
            barWidth: 6,
            height: 30,
        });
        $('#site-visits').sparkline('html', {
            type: 'bar',
            barColor: '#f63131',
            barWidth: 6,
            height: 30,
        });
    });

    //wysihtml5
    $('#wysiwyg').wysihtml5();
</script>
</body>
</html>
<?php
ob_end_flush();
       /*if(isset($_SESSION['ulevel'])) {

            switch($_SESSION['ulevel']) {
                case 'owner': // Registered users access
                    echo '
                        <li><a href="'.BASE_URL.'/admin/admin.php">Admin CP</a></li>
                        <li><a href="'.BASE_URL.'/users/profile.php">User Profile</a></li>
                        <li><a href="'.BASE_URL.'/users/change_password.php">Change Password</a></li>
                        <li><a href="'.BASE_URL.'/users/logout.php">Log Out</a></li>
                        ';
                    break;

                case 'admin':
                    echo '
                        <li><a href="'.BASE_URL.'/admin/admin.php">Admin CP</a></li>
                        <li><a href="'.BASE_URL.'/users/profile.php">User Profile</a></li>
                        <li><a href="'.BASE_URL.'/users/change_password.php">Change Password</a></li>
                        <li><a href="'.BASE_URL.'/users/logout.php">Log Out</a></li>
                    ';
                    break;

                case 'mod':
                    echo '
                        <li><a href="'.BASE_URL.'/admin/admin.php">Admin CP</a></li>
                        <li><a href="'.BASE_URL.'/users/profile.php">User Profile</a></li>
                        <li><a href="'.BASE_URL.'/users/change_password.php">Change Password</a></li>
                        <li><a href="'.BASE_URL.'/users/logout.php">Log Out</a></li>
                    ';
                    break;

                case 'normal':
                    echo '
                        <li><a href="'.BASE_URL.'/users/profile.php">User Profile</a></li>
                        <li><a href="'.BASE_URL.'/users/change_password.php">Change Password</a></li>
                        <li><a href="'.BASE_URL.'/users/logout.php">Log Out</a></li>
                    ';
                    break;

                default:
                    echo '
                        <li><a href="'.BASE_URL.'/users/register.php">Register</a></li>
                        <li><a href="'.BASE_URL.'/users/login.php">Login</a></li>
                    ';
                    break;

            }

        } else {
            // Neu khong co $_SESSION
            echo '
                <li><a href="'.BASE_URL.'/users/register.php">Register</a></li>
                <li><a href="'.BASE_URL.'/users/login.php">Login</a></li>
            ';
        }*/
        ?>