<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{asset('inspinia/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('inspinia/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <!-- Morris -->
    <link href="{{asset('inspinia/css/plugins/morris/morris-0.4.3.min.css')}}" rel="stylesheet">

    <link href="{{asset('inspinia/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('inspinia/css/style.css')}}" rel="stylesheet">

    <link href="{{asset('inspinia/css/fstdropdown.css')}}" rel="stylesheet" type="text/css" />

   
    <link href="{{asset('inspinia/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('inspinia/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('inspinia/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
   

</head>

<body>
    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> 
                        <span>
                            <img alt="image" class="img-circle" src="{{asset('inspinia/img/profile_small.jpg')}}" width="80px" height="60px" />
                        </span>
                       
                    </div>
                    <div class="logo-element">
                        <center> 
                        <img alt="image" class="img-circle" src="{{asset('inspinia/img/profile_small.jpg')}}" width="40px" height="30px"/></center>
                    </div>
                </li>
               <li class="{{ Request::is('home*') ? 'active' : '' }}">


                   <a href="{{url('home')}}"> <i class="fa fa-dashboard" style="color:#1AB394"></i> Dashboard</a>
               </li>           



                @if(Bouncer::can('Create_Email')) 

                <li class="{{ Request::is('emails*') ? 'active' : '' }}">
                    <a href="{{url('emails')}}"><i class="fa fa-envelope" style="color:#1AB394" aria-hidden="true"></i> <span class="nav-label">Communication</span></a>
                </li>
                @endif






                <!-- START OF USER AUTHENTICATION TAB -->
                @if(Bouncer::can('Create_User')) 

                 <li class="nav metismenu @if(Request::is('users')
                             ||Request::is('roles')
                             ){{'active open selected'}};@endif ">
                                    <a href="#" class="nav-link nav-toggle">
                                        <i class="fa fa-user" style="color:#1AB394"></i>
                                        <span class="title">Authentication</span>
                                        
                                    </a>
                                    <ul class="nav metismenu">
                                        @if(Bouncer::can('Create_Role')) 

                                            <li class="{{ Request::is('roles*') ? 'active' : '' }}">
                                                <a href="{{url('roles')}}"><i class="fa fa-diamond" style="color:#1AB394"></i> <span class="nav-label">Roles</span></a>
                                            </li>

                                        @endif

                                        @if(Bouncer::can('Create_User')) 
                                             <li class="{{ Request::is('users*') ? 'active' : '' }}">
                                                <a href="{{url('users')}}"><i class="fa fa-user" style="color:#1AB394"></i> <span class="nav-label">Users</span></a>
                                            </li>

                                        @endif

                                    </ul>
                    </li>
                 @endif
                 <!-- END -->

                 <!-- START OF THE SETTINGS TAB -->
                @if(Bouncer::can('Create_User')) 

                 <li class="nav metismenu @if(Request::is('countries') ||Request::is('upload-countries*')
                 ||Request::is('post-upload-countries*') || Request::is('statuses') || Request::is('paymentmodes') || Request::is('departments')
                 ){{'active open selected'}};@endif ">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-cogs" style="color:#1AB394"></i>
                                    <span class="title">Catalog</span>
                                    
                                </a>
                        <ul class="nav metismenu">
                             @if(Bouncer::can('Create_Country')) 
                                <li class="{{ Request::is('countries*') ? 'active' : '' }}">
                                    <a href="{{url('countries')}}"><i class="fa fa-flag" style="color:#1AB394"></i> <span class="nav-label">Countries</span></a>
                                </li>

                            @endif

                          

                            @if(Bouncer::can('Create_Status')) 

                                <li class="{{ Request::is('statuses*') ? 'active' : '' }}">
                                    <a href="{{url('statuses')}}"><i class="fa fa-angle-double-right" style="color:#1AB394"></i> <span class="nav-label">Statuses</span></a>
                                </li>

                            @endif

                             @if(Bouncer::can('Create_Paymentmode')) 

                                        <li class="{{ Request::is('paymentmodes*') ? 'active' : '' }}">
                                            <a href="{{url('paymentmodes')}}"><i class="fa fa-money" style="color:#1AB394"></i> <span class="nav-label">Payment Mode</span></a>
                                        </li>

                            @endif
                            @if(Bouncer::can('Create_Department')) 

                            <li class="{{ Request::is('departments*') ? 'active' : '' }}">
                                <a href="{{url('departments')}}"><i class="fa fa-database" style="color:#1AB394"></i> <span class="nav-label">Departments</span></a>
                            </li>

                            @endif 


                         

                        </ul>
                    </li>

                    @endif


                      @if(Bouncer::can('Create_LogActivity'))

                        <li class="nav metismenu @if(Request::is('log-activities')
                             ||Request::is('monitor')
                             ){{'active open selected'}};@endif ">
                                    <a href="#" class="nav-link nav-toggle">
                                        <i class="fa fa-sliders" style="color:#1AB394"></i>
                                        <span class="title">System Logs</span>
                                        
                                    </a>
                                    <ul class="nav metismenu">
                                        

                                        <li class="nav {{ Request::is('log-activities*') ? 'active' : '' }}">
                                            <a href="{{ route('log-activities.index') }}"><i class="fa fa-sliders" style="color:#1AB394"></i> <span class="nav-label">Log Activity</a>
                                        </li>
                                      
                                        <li class="{{ Request::is('monitor*') ? 'active' : '' }}">
                                            <a href="{{url('/monitor')}}"><i class="fa fa-file-text" style="color:#1AB394"></i> <span class="nav-label">Server Monitor</span></a>
                                        </li>

                                       

                                    </ul>
                        </li>

                    @endif

  
            </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
               
 <!--                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a7.jpg">
                                </a>
                                <div>
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a4.jpg">
                                </a>
                                <div>
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/profile.jpg">
                                </a>
                                <div>
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li> -->

                <!-- <li>
                    
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          
                            <span class="text-muted text-xs block"><i class="fa fa-user" style="color:#1AB394"></i>  {{Auth::user()->name}} <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="{{url('users/profile')}}"><i class="fa fa-user" style="color:#1AB394"></i>Profile</a></li> 
                            <li class="divider"></li>  
                            <li><a href="{{url('users/password-edit')}}"><i class="fa fa-key" style="color:#1AB394"></i>Change Password</a></li>                            
                            <li class="divider"></li>
                            <li><a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off" style="color:#1AB394"></i> Logout</a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }} </form>
                            </li>
                        </ul>
                  
                </li> -->

                <li>
                    
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          
                           
                    <span class="text-muted text-xs block"> <i class="fa fa-user" style="color:#1AB394"></i> {{Auth::user()->first_name}} {{Auth::user()->middle_name}} {{Auth::user()->last_name}} <b class="caret"></b>
                    </span> </a>
                        
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{url('users/profile')}}">  <i class="fa fa-user" style="color:#1AB394"></i> Profile</a></li> 
                        <li class="divider"></li>  
                        <li><a href="{{url('users/password-edit')}}"> <i class="fa fa-key" style="color:#1AB394"></i>  Change Password</a></li>                            
                        <li class="divider"></li>
                        <li><a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off" style="color:#1AB394"></i> Logout</a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }} </form>
                         </li>
                    </ul>
                  
                </li>




                
            </ul>

        </nav>
        </div>

            <div class="flash-message">
                  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }}">{!! Session::get('alert-' . $msg) !!}</p>
                    @endif
                  @endforeach
            </div>

          @yield('content')

        <div class="footer">
           <!--  <div class="pull-right">
                10GB of <strong>250GB</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2017
            </div> -->
             <div class="page-footer-inner"> {{date('Y',time())}} &copy; &nbsp;{{ config('app.name', 'Laravel') }} &nbsp;|&nbsp;
                    <a href="https://techdevsystems.co.ke" target="_blank">Techdev Systems</a>
            </div>
        </div>

        </div>
     
    </div>

    <!-- Mainly scripts -->
    <script   src="{{asset('inspinia/js/jquery-3.1.1.min.js')}}"></script>
    <script   src="{{asset('inspinia/js/bootstrap.min.js')}}"></script>
    <script   src="{{asset('inspinia/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script   src="{{asset('inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Flot -->
    <script   src="{{asset('inspinia/js/plugins/flot/jquery.flot.js')}}"></script>
    <script   src="{{asset('inspinia/js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
    <script   src="{{asset('inspinia/js/plugins/flot/jquery.flot.spline.js')}}"></script>
    <script   src="{{asset('inspinia/js/plugins/flot/jquery.flot.resize.js')}}"></script>
    <script   src="{{asset('inspinia/js/plugins/flot/jquery.flot.pie.js')}}"></script>
    <script   src="{{asset('inspinia/js/plugins/flot/jquery.flot.symbol.js')}}"></script>
    <script   src="{{asset('inspinia/js/plugins/flot/curvedLines.js')}}"></script>

    <!-- Peity -->
    <script   src="{{asset('inspinia/js/plugins/peity/jquery.peity.min.js')}}"></script>
    <script   src="{{asset('inspinia/js/demo/peity-demo.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script   src="{{asset('inspinia/js/inspinia.js')}}"></script>
    <script   src="{{asset('inspinia/js/plugins/pace/pace.min.js')}}"></script>

    <!-- jQuery UI -->
    <script   src="{{asset('inspinia/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Jvectormap -->
    <script   src="{{asset('inspinia/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script   src="{{asset('inspinia/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

    <!-- Sparkline -->
    <script   src="{{asset('inspinia/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script   src="{{asset('inspinia/js/demo/sparkline-demo.js')}}"></script>

    <!-- ChartJS-->
    <script   src="{{asset('inspinia/js/plugins/chartJs/Chart.min.js')}}"></script>

     <script src="{{asset('inspinia/js/fstdropdown.js')}}" type="text/javascript"></script>

  
    <!-- iCheck -->
    <script src="{{asset('inspinia/js/plugins/iCheck/icheck.min.js')}}"></script>

    <!-- SUMMERNOTE -->
    <script src="{{asset('inspinia/js/plugins/summernote/summernote.min.js')}}"></script>



    @yield('scripts')

    <script>
        $(document).ready(function() {


            var d1 = [[1262304000000, 6], [1264982400000, 3057], [1267401600000, 20434], [1270080000000, 31982], [1272672000000, 26602], [1275350400000, 27826], [1277942400000, 24302], [1280620800000, 24237], [1283299200000, 21004], [1285891200000, 12144], [1288569600000, 10577], [1291161600000, 10295]];
            var d2 = [[1262304000000, 5], [1264982400000, 200], [1267401600000, 1605], [1270080000000, 6129], [1272672000000, 11643], [1275350400000, 19055], [1277942400000, 30062], [1280620800000, 39197], [1283299200000, 37000], [1285891200000, 27000], [1288569600000, 21000], [1291161600000, 17000]];

            var data1 = [
                { label: "Data 1", data: d1, color: '#17a084'},
                { label: "Data 2", data: d2, color: '#127e68' }
            ];
            $.plot($("#flot-chart1"), data1, {
                xaxis: {
                    tickDecimals: 0
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 1
                            }, {
                                opacity: 1
                            }]
                        },
                    },
                    points: {
                        width: 0.1,
                        show: false
                    },
                },
                grid: {
                    show: false,
                    borderWidth: 0
                },
                legend: {
                    show: false,
                }
            });

            var lineData = {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [
                    {
                        label: "Example dataset",
                        backgroundColor: "rgba(26,179,148,0.5)",
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                        data: [48, 48, 60, 39, 56, 37, 30]
                    },
                    {
                        label: "Example dataset",
                        backgroundColor: "rgba(220,220,220,0.5)",
                        borderColor: "rgba(220,220,220,1)",
                        pointBackgroundColor: "rgba(220,220,220,1)",
                        pointBorderColor: "#fff",
                        data: [65, 59, 40, 51, 36, 25, 40]
                    }
                ]
            };

            var lineOptions = {
                responsive: true
            };


            var ctx = document.getElementById("lineChart").getContext("2d");
            new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});


        });
    </script>
     <script type="text/javascript">
            
            function ConfirmDelete()
            {
            var x = confirm("Are you sure you want to delete?");
            if (x)
            return true;
            else
            return false;
            }


            function ConfirmReset()
            {
            var x = confirm("Are you sure you want to reset the password?");
            if (x)
            return true;
            else
            return false;
            }

            function ConfirmDrop()
            {
            var x = confirm("Are you sure you want to drop this request?");
            if (x)
            return true;
            else
            return false;
            }


        </script>
</body>
</html>
