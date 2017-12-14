<button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">☰</button>
<a class="navbar-brand d-md-down-none" href="{{ route('admin.index') }}">{{ $company->name }}</a>
<ul class="nav navbar-nav d-md-down-none">
    <li class="nav-item">
        <a class="nav-link navbar-toggler sidebar-toggler" href="#">☰</a>
    </li>

    <li class="nav-item px-3">
        <a class="nav-link" href="{{ route('admin.index') }}">Dashboard</a>
    </li>

</ul>
<ul class="nav navbar-nav ml-auto">
    <li class="nav-item d-md-down-none ">
        <a class="nav-link" href="{{ route('invoice.index') }}"><i class="fa fa-bell-o" aria-hidden="true"></i><span class="badge badge-pill badge-danger">{{ $active_invoices }}</span></a>
    </li>
    <li class="nav-item d-md-down-none">
        <a class="nav-link navbar-toggler aside-menu-toggler" href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i><span id="navCount" class="badge badge-pill badge-danger" style="font-size: 10px;">{{ $count_contactus }}</span></a>
    </li>
    <li class="nav-item dropdown" style="padding-right: 2rem;">
        <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="">{{ Auth::user()->email }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">

            <div class="dropdown-header text-center">
                <strong>Settings</strong>
            </div>

            <a class="dropdown-item" href="{{ route('employee.edit',auth()->user()->id) }}"><i class="fa fa-user"></i> My Account</a>
            <div class="divider"></div>
            <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="fa fa-lock"></i> Logout</a>
        </div>
    </li>


</ul>