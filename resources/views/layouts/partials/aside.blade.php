<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo"  style="overflow: visible">
        <a href="{{ route('dashboard.home') }}" class="app-brand-link">
            <span class="app-brand-logo demo" style="overflow: visible">
                <img src=" {{ asset('imgs/logo.png') }}" alt="Logo" width="60">
            </span>
            {{-- <span class="app-brand-text demo menu-text fw-bold">{{ $title }}</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps &amp; Pages">العامة</span>
        </li>
        <!-- Page -->
        <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
            <a href="{{ route('dashboard.home') }}" class="menu-link">
                <i class="fa-solid fa-house me-2"></i>
                <div data-i18n="home">الرئيسية</div>
            </a>
        </li>
        <li class="menu-item  {{ request()->is('suppliers/*') || request()->is('suppliers') ? 'active' : '' }}">
            <a href="{{ route('dashboard.suppliers.index') }}" class="menu-link">
                <i class="fa-solid fa-truck-field me-2"></i>
                <div data-i18n="suppliers">الموردين</div>
            </a>
        </li>

        <li class="menu-item  {{ request()->is('categories/*') || request()->is('categories') ? 'active' : '' }}">
            <a href="{{ route('dashboard.categories.index') }}" class="menu-link">
                <i class="fa-solid fa-truck-field me-2"></i>
                <div data-i18n="categories">الاقسام</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="fa-solid fa-gear me-2"></i>
                <div data-i18n="settings">قائمة المنتجات</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('products/*') || request()->is('products') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.products.index') }}" class="menu-link">
                        <i class="fa-solid fa-users me-2"></i>
                        <div data-i18n="products">المنتجات</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('flavors/*') || request()->is('flavors') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.flavors.index') }}" class="menu-link">
                        <i class="fa-solid fa-calendar-days me-2"></i>
                        <div data-i18n="flavors">النكهات</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('sizes/*') || request()->is('sizes') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.sizes.index') }}" class="menu-link">
                        <i class="fa-solid fa-calendar-days me-2"></i>
                        <div data-i18n="sizes">الاحجام</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('quantitytypes/*') || request()->is('quantitytypes') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.quantitytypes.index') }}" class="menu-link">
                        <i class="fa-solid fa-calendar-days me-2"></i>
                        <div data-i18n="quantitytypes">الكميات</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('stocks/*') || request()->is('stocks') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.stocks.index') }}" class="menu-link">
                        <i class="fa-solid fa-calendar-days me-2"></i>
                        <div data-i18n="stocks">التخزين</div>
                    </a>
                </li>
                

                
            </ul>
        </li>


        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps &amp; Pages">إدارة النظام</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="fa-solid fa-gear me-2"></i>
                <div data-i18n="settings">الإعدادات</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('users/*') || request()->is('users') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.users.index') }}" class="menu-link">
                        <i class="fa-solid fa-users me-2"></i>
                        <div data-i18n="users">المستخدمين</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('logs/*') || request()->is('logs') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.logs.index') }}" class="menu-link">
                        <i class="fa-solid fa-calendar-days me-2"></i>
                        <div data-i18n="logs">الأحداث</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('constants/*') || request()->is('constants') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.constants.index') }}" class="menu-link">
                        <i class="fa-solid fa-cube me-2"></i>
                        <div data-i18n="constants">ثوابت النظام</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('currencies/*') || request()->is('currencies') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.currencies.index') }}" class="menu-link">
                        <i class="fa-solid fa-coins me-2"></i>
                        <div data-i18n="currencies">العملات</div>
                    </a>
                </li>
                
            </ul>
        </li>
        {{-- <li class="menu-item">
            <a href="page-2.html" class="menu-link">
                <i class="menu-icon tf-icons ti ti-app-window"></i>
                <i class="fa-solid fa-house me-2"></i>
                <div data-i18n="Page 2">Page 2</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="index.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-chart-pie-2"></i>
                        <div data-i18n="Analytics">Analytics</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="dashboards-crm.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-3d-cube-sphere"></i>
                        <div data-i18n="CRM">CRM</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-ecommerce-dashboard.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                        <div data-i18n="eCommerce">eCommerce</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-logistics-dashboard.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-truck"></i>
                        <div data-i18n="Logistics">Logistics</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="app-academy-dashboard.html" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-book"></i>
                        <div data-i18n="Academy">Academy</div>
                    </a>
                </li>
            </ul>
        </li> --}}
    </ul>
    <div class="text-body text-white text-center my-3">
        ©
        2025
        , تم الإنشاء ❤️ بواسطة <a href="https://saeyd-jamal.github.io/My_Portfolio/" target="_blank"
            class="footer-link">م . السيد الاخرسي</a>
    </div>
</aside>