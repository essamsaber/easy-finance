<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->gravatar() }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li>
                <a href="{{ url('/home') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('sources.index') }}">
                    <i class="fa fa-briefcase"></i> <span>Sources of Income</span>
                </a>
            </li>

            <li>
                <a href="{{ route('expense-items.index') }}">
                    <i class="fa fa-file-excel-o"></i> <span>Expense Items</span>
                </a>
            </li>

            <li>
                <a href="{{ route('income.index') }}">
                    <i class="fa fa-money"></i> <span>Income</span>
                </a>
            </li>

            <li>
                <a href="{{ route('payment.index') }}">
                    <i class="fa fa-credit-card"></i> <span>Payments</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
