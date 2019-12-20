<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar" style="margin-top: 15px;overflow: auto;padding-bottom: 100px">
        <!-- User Info -->
    @include('user.Layout.home.left_content'.$root)       <!-- #Footer -->

    </aside>
    <!-- #END# Left Sidebar -->
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar" style="padding:10px;margin-top: 10px;overflow: auto;">
    @include('user.Layout.home.right_content')
    </aside>
    <!-- #END# Right Sidebar -->
</section>