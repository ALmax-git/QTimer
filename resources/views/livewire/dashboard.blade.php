    <div class="container-fluid position-relative d-flex p-0">
      <!-- Spinner Start -->
      {{-- <div
        class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
        id="spinner">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
          <span class="sr-only">Loading...</span>
        </div>
      </div> --}}
      <!-- Spinner End -->

      <!-- Sidebar Start -->
      <div class="sidebar pb-3 pe-4">
        <nav class="navbar bg-secondary navbar-dark">
          <a class="navbar-brand mx-4 mb-3" href="#">
            <h3 class="text-primary"><u><i class="fa fa-user-edit me-2"></i>QTimer</u></h3>
          </a>
          <div class="d-flex align-items-center mb-4 ms-4">
            <div class="position-relative">
              <img class="rounded-circle"
                src="{{ Auth::user()->profile_photo_path ? Auth::user()->profile_photo_path : 'default.png' }}"
                alt="" style="width: 40px; height: 40px;">
              <div class="bg-success rounded-circle position-absolute bottom-0 end-0 border border-2 border-white p-1">
              </div>
            </div>
            <div class="ms-3">
              <h6 class="mb-0">{{ Auth::user()->name }}</h6>
              <span>{{ Auth::user()->email }}</span>
            </div>
          </div>
          <div class="navbar-nav w-100">

            <span class="nav-item nav-link {{ $tab == 'Dashboard' ? 'active' : '' }}" href="#"
              wire:click='toggle_tab("Dashboard")'><i class="fa fa-tachometer-alt me-2"></i>Dashboard</span>
            {{-- 
            <span class="nav-item nav-link {{ $tab == 'Students' ? 'active' : '' }}" href="#"
              wire:click='toggle_tab("Students")'><i class="fa fa-user-graduate me-2"></i>Students</span>
            <span class="nav-item nav-link {{ $tab == 'Class' ? 'active' : '' }}" href="#"
              wire:click='toggle_tab("Class")'><i class="fa fa-th me-2"></i>Classes</span> --}}
          </div>
        </nav>
      </div>
      <!-- Sidebar End -->

      <!-- Content Start -->
      <div class="content">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
          <a class="navbar-brand d-flex d-lg-none me-4" href="index.html">
            <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
          </a>
          <a class="sidebar-toggler flex-shrink-0" href="#">
            <i class="fa fa-bars"></i>
          </a>
          <form class="d-none d-md-flex ms-4">
            <input class="form-control bg-dark border-0" type="search" placeholder="Search">
          </form>
          <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                <i class="fa fa-envelope me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Message</span>
              </a>
              <div class="dropdown-menu dropdown-menu-end bg-secondary rounded-0 rounded-bottom m-0 border-0">
                {{-- <a class="dropdown-item" href="#">
                  <div class="d-flex align-items-center">
                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                    <div class="ms-2">
                      <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                      <small>15 minutes ago</small>
                    </div>
                  </div>
                </a> --}}
                <hr class="dropdown-divider">
                <a class="dropdown-item text-center" href="#">Comming Soon</a>
              </div>
            </div>
            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                <i class="fa fa-bell me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Notificatin</span>
              </a>
              <div class="dropdown-menu dropdown-menu-end bg-secondary rounded-0 rounded-bottom m-0 border-0">
                {{-- <a class="dropdown-item" href="#">
                  <h6 class="fw-normal mb-0">Password changed</h6>
                  <small>15 minutes ago</small>
                </a> --}}
                <hr class="dropdown-divider">
                <a class="dropdown-item text-center" href="#">Comming Soon</a>
              </div>
            </div>
            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                <img class="rounded-circle me-lg-2"
                  src="{{ Auth::user()->profile_photo_path ? Auth::user()->profile_photo_path : 'default.png' }}"
                  alt="" style="width: 40px; height: 40px;">
                <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-end bg-secondary rounded-0 rounded-bottom m-0 border-0">
                <a class="dropdown-item" href="#">My Profile</a>
                <a class="dropdown-item" wire:click='logout'>Log Out</a>
                <a class="dropdown-item" wire:click='exit_qtimer'>Exit</a>
              </div>
            </div>
          </div>
        </nav>

        @switch($tab)
          @case('Dashboard')
            <livewire:dashboard.control />
          @break

          @default
        @endswitch

        <!-- Footer Start -->
        <div class="container-fluid px-4 pt-4">
          <div class="bg-secondary rounded-top p-4">
            <div class="row">
              <div class="col-12 col-sm-6 text-sm-start text-center">
                <center>
                  <p>&copy; <strong>ALmax</strong>, All Right Reserved.</p>
                </center>
              </div>
            </div>
          </div>
        </div>
        <!-- Footer End -->
      </div>
      <!-- Content End -->

      <!-- Back to Top -->
      <a class="btn btn-lg btn-primary btn-lg-square back-to-top" href="#"><i class="bi bi-arrow-up"></i></a>
    </div>
