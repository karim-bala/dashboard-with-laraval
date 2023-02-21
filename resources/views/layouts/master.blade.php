<!--
Main Page for side bar in admin lte
-->

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AdminLTE 3 | Starter</title>



    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/style.css">

</head>

<body class="hold-transition sidebar-mini" >
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>

            </ul>


            <!-- SEARCH FORM -->

                <div class="input-group input-group-sm ">
                    <input class="form-control form-control-navbar" v-model="search" @keyup="searchUser" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" @click="searchUser">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>



        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                {{-- <img src="/storage/images/gear.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8"> --}}
                <span class="brand-text font-weight-light">Dashboard</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image ">
                        <img  src="https://ui-avatars.com/api/?name={{Auth::user()->name}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            {{Auth::user()->name}}
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <router-link to="/dashboard" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt blue"></i>
                                <p>
                                    Dashboard
                                </p>
                            </router-link>
                        </li>


                        @can('isAdminOrAuthor')
                        <li class="nav-item has-treeview ">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-cog green"></i>
                                <p>
                                    Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/users" class="nav-link ">
                                        <i class="fas fa-users nav-icon lightGreen"></i>
                                        <p>Users </p>
                                    </router-link>
                                </li>

                            </ul>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <router-link to="/profile" class="nav-link">
                                <i class="nav-icon fas fa-user teal"></i>
                                <p>
                                    Profile
                                </p>
                            </router-link>
                        </li>
                        @can('isAdminOrAuthor')

                        <li class="nav-item">
                            <router-link to="/developer" class="nav-link">
                                <i class="nav-icon fas fa-users-cog teal"></i>
                                <p>
                                    Developer
                                </p>
                            </router-link>
                        </li>
                        @endcan

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                               <i class="nav-icon fas fa-power-off red"></i>
                               <p>
                               {{ __('Logout') }}
                               </p>

                             </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                             </form>


                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <router-view> </router-view>
                    <!-- set progressbar -->
                    <vue-progress-bar></vue-progress-bar>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wraper -->





        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->
    @auth
<script>
    window.user = @json(auth()->user())
</script>
@endauth


    <script src="/js/app.js"></script>
    <script src="/js/script.js"></script>
</body>

</html>
