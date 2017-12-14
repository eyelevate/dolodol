    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.index') }}"><i class="icon-speedometer"></i> Dashboard</a>
                </li>

                <li class="nav-item">
                    <form class="form-horizontal" method="POST" action="">
                        {{ csrf_field() }}
                        <input id="" placeholder="search.." type="text" class="form-control" name="search" value="{{ old('search') }}" required autofocus>
                    </form>
                </li>

                <li class="nav-title">
                    Menu
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Users</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.index') }}"><i class="icon-arrow-right-circle"></i> Customers <span class="badge badge-info">{{ $customer_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employee.index') }}"><i class="icon-arrow-right-circle"></i> Employees <span class="badge badge-info">{{ $employee_count }}</span></a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-shopping-basket"></i> Collections </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('collection.create') }}"><i class="icon-arrow-right-circle"></i> Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('collection.index') }}"><i class="icon-arrow-right-circle"></i> Manage <span class="badge badge-info">{{ $collections_count }}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-diamond"></i> Inventory</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inventory.create') }}"><i class="icon-arrow-right-circle"></i> Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inventory.index') }}"><i class="icon-arrow-right-circle"></i> Manage <span class="badge badge-info">{{ $inventory_count }}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-wrench"></i> Setup</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('company.index') }}"><i class="icon-arrow-right-circle"></i> Company <span class="badge badge-info">{{ $companies_count }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tax.index') }}"><i class="icon-arrow-right-circle"></i> Sales Tax </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-archive"></i> Invoice(s)</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('invoice.create') }}"><i class="icon-arrow-right-circle"></i> Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('invoice.index') }}"><i class="icon-arrow-right-circle"></i> Manage <span class="badge badge-info">{{ $invoice_count }}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">  
                    <a class="nav-link" href="{{ route('report.index') }}"><i class="icon-pie-chart"></i> Reports</a>
                </li>


            </ul>
        </nav>
    </div>