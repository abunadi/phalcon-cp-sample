<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="{{ dashboard_active }}">{{ link_to('index', '<span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> <span>Dashboard</span>', 'class' : '') }}</li>
            <li class="treeview {{ categories_active }}">
                <a href="#"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> <span>Categories</span> <span class="glyphicon glyphicon-menu-left pull-right" aria-hidden="true"></span></a>
                <ul class="treeview-menu">
                    <li class="{{ new_category_active }}">{{ link_to('categories/new', 'Add New Category') }}</li>
                    <li class="{{ show_categories_active }}">{{ link_to('categories/show', 'Show All Categories') }}</li>
                </ul>
            </li>
            <li class="treeview {{ items_active }}">
                <a href="#"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> <span>Items</span> <span class="glyphicon glyphicon-menu-left pull-right" aria-hidden="true"></span></a>
                <ul class="treeview-menu">
                    <li class="{{ new_item_active }}">{{ link_to('items/new', 'Add New Item') }}</li>
                    <li class="{{ show_items_active }}">{{ link_to('items/show', 'Show All Items') }}</li>
                </ul>
            </li>
      </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
