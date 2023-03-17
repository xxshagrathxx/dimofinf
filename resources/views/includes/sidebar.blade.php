    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home') }}">
            <i class="mdi mdi-home menu-icon"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
            <i class="mdi mdi-database menu-icon"></i>
            <span class="menu-title">Category</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="ui-basic2">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="{{ route('category.view') }}">Category</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('category.create') }}">Create a Category</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('category.excel.view') }}">Import Categories</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
            <i class="mdi mdi-receipt menu-icon"></i>
            <span class="menu-title">Products</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="{{ route('product.view') }}">Products</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('product.create') }}">Create a Product</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('product.excel.view') }}">Import Products</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic3">
              <i class="mdi mdi-account-multiple menu-icon"></i>
              <span class="menu-title">Customers</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic3">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('customer.view') }}">Customers</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('customer.create') }}">Create a Customer</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('customer.excel.view') }}">Import Customers</a></li>
              </ul>
            </div>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="{{ route('currency.view') }}">
            <i class="mdi mdi-currency-usd menu-icon"></i>
            <span class="menu-title">Currencies</span>
          </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic4" aria-expanded="false" aria-controls="ui-basic4">
              <i class="mdi mdi-note-text menu-icon"></i>
              <span class="menu-title">Quotations</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic4">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('quotation.list') }}">Quotations</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('quotation.index') }}">Create a Quotation</a></li>
              </ul>
            </div>
        </li>

        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) <!-- Super admin or admin -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic5" aria-expanded="false" aria-controls="ui-basic5">
                <i class="mdi mdi-account-switch menu-icon"></i>
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic5">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('user.view') }}">Users</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('user.create') }}">Create a User</a></li>
                </ul>
                </div>
            </li>
        @endif

        {{--<li class="nav-item">
          <a class="nav-link" href="pages/charts/chartjs.html">
            <i class="mdi mdi-chart-pie menu-icon"></i>
            <span class="menu-title">Charts</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pages/tables/basic-table.html">
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">Tables</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pages/icons/mdi.html">
            <i class="mdi mdi-emoticon menu-icon"></i>
            <span class="menu-title">Icons</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
            <i class="mdi mdi-account menu-icon"></i>
            <span class="menu-title">User Pages</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="auth">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
              <li class="nav-item"> <a class="nav-link" href="pages/samples/login-2.html"> Login 2 </a></li>
              <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
              <li class="nav-item"> <a class="nav-link" href="pages/samples/register-2.html"> Register 2 </a></li>
              <li class="nav-item"> <a class="nav-link" href="pages/samples/lock-screen.html"> Lockscreen </a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="documentation/documentation.html">
            <i class="mdi mdi-file-document-box-outline menu-icon"></i>
            <span class="menu-title">Documentation</span>
          </a>
        </li> --}}
      </ul>
    </nav>
    <!-- partial -->




