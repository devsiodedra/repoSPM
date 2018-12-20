<!-- Begin Page Content -->
<?php
$controller = $this->router->fetch_class();
$method = $this->router->fetch_method();
?>

<style type="text/css">
    /* .icon-basket .path2:before {
        content: "\e901";
    } */
    .icon-bee:before {
        content: "\e903";
    }
</style>
            <div class="page-content d-flex align-items-stretch">
                <div class="default-sidebar">
                    <!-- Begin Side Navbar -->
                    <nav class="side-navbar box-scroll sidebar-scroll">
                        <!-- Begin Main Navigation -->
                        <ul class="list-unstyled">
                            <!-- <li class = "<?= $controller == 'dashboard' ? 'active' : '' ?>"><a href="dashboard"><i class="la la-dashboard"></i><span>Dashboard</span></a></li> -->
                           <!--  <li class = "<?= ($controller == 'category' || $controller == 'category') ? 'active' : '' ?>"><a href="category"><i class="la la-database"></i><span> Category</span></a></li> -->
                            <li class = "<?= ($controller == 'category') ? 'active' : '' ?>">
                                <a href="#dropdown-app" aria-expanded="<?= ($controller == 'category') ? 'true' : 'false' ?>" data-toggle="collapse"><i class="la la-puzzle-piece">
                                    </i><span>Category</span>
                                </a>
                                <ul id="dropdown-app" class="collapse list-unstyled pt-0 <?= ( $controller == 'category') ? ' show' : '' ?>">
                                   <li><a href="category" class="<?= ($controller == 'category') ? 'active' : '' ?>">Default Category</a></li>
                                    
                                    
                                </ul>
                            </li>
                           
                            <li class = "<?= ($controller == 'customer') ? 'active' : '' ?>">
                                <a href="#dropdown-app2" aria-expanded="<?= ($controller == 'customer') ? 'true' : 'false' ?>" data-toggle="collapse"><i class="la la-group">
                                    </i><span>Users</span>
                                </a>
                                <ul id="dropdown-app2" class="collapse list-unstyled pt-0 <?= ($controller == 'customer' ) ? ' show' : '' ?>">
                                    <li><a href="customer" class="<?= ($controller == 'customer' && $method == 'index') ? 'active' : '' ?>">All User</a></li>
                                    
                                    
                                </ul>
                            </li>
                            
                          <!--   <li class = "<?= ($controller == 'banner' || $controller == 'banner') ? 'active' : '' ?>"><a href="banner"><i class="la la-database"></i><span> Banner</span></a></li> -->
                            <li class = "<?= $controller == 'cms' ? 'active' : '' ?>">
                                <a href="#dropdown-app3" aria-expanded="<?= $controller == 'cms' ? 'true' : 'false' ?>" data-toggle="collapse"><i class="la la-puzzle-piece">
                                    </i><span>CMS</span>
                                </a>
                                <ul id="dropdown-app3" class="collapse list-unstyled pt-0 <?= $controller == 'cms' ? ' show' : '' ?>">
                                    <li><a href="cms/page/terms_condition">Terms and Conditions</a></li>
                                    <li><a href="cms/page/privacy_policy">Privacy Policy</a></li>
                                </ul>
                            </li>
                            <li class = "<?= $controller == 'settings' ? 'active' : '' ?>">
                                <a href="#dropdown-app4" aria-expanded="<?= $controller == 'settings' ? 'true' : 'false' ?>" data-toggle="collapse"><i class="la la-cog">
                                    </i><span>Settings</span>
                                </a>
                                <ul id="dropdown-app4" class="collapse list-unstyled pt-0 <?= $controller == 'settings' ? ' show' : '' ?>">
                                    <li><a href="settings">Email Config</a></li>
                                </ul>
                            </li>
                          
                        </ul>
                        <!-- <span class="heading">CMS Content</span>
                        <ul class="list-unstyled">
                           <li><a href="#dropdown-app" aria-expanded="false" data-toggle="collapse"><i class="la la-puzzle-piece"></i><span>Applications</span></a>
                                <ul id="dropdown-app" class="collapse list-unstyled pt-0">
                                    <li><a href="app-calendar.html">Calendar</a></li>
                                    <li><a href="app-chat.html">Chat</a></li>
                                    <li><a href="app-mail.html">Mail</a></li>
                                    <li><a href="app-contact.html">Contact</a></li>
                                </ul>
                            </li>
                        </ul> -->
                      
                        <!-- End Main Navigation -->
                    </nav>
                    <!-- End Side Navbar -->
                </div>