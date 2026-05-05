<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="gradient" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Dashboard | Hybrix - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Minimal Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- jsvectormap css -->
    <link href="{{ asset('assets/backend/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('assets/backend/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/backend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/libs/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Include Bubble Theme -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- App Css-->
    <link href="{{ asset('assets/backend/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/backend/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .table-responsive .dropdown-menu {
            position: fixed !important;
        }
    </style>
    @stack('css')
    @livewireStyles
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <livewire:backend.theme.tagbar />
        <livewire:backend.theme.header />

        <!-- removeNotificationModal -->
        <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="NotificationModalbtn-close"></button>
                    </div>
                    <div class="modal-body p-md-5">
                        <div class="text-center">
                            <div class="text-danger">
                                <i class="bi bi-trash display-4"></i>
                            </div>
                            <div class="mt-4 fs-15">
                                <h4 class="mb-1">Are you sure ?</h4>
                                <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete
                                It!</button>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!-- ========== App Menu ========== -->
        <livewire:backend.theme.sidebar />
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <div>
                <button type="button"
                    class="btn-success btn-rounded shadow-lg btn btn-icon layout-rightside-btn fs-22"><i
                        class="ri-chat-smile-2-line"></i></button>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            © Hybrix.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Themesbrand
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script data-navigate-once="" src="https://code.jquery.com/jquery-4.0.0.js"
        integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
    <script data-navigate-once src="{{ asset('assets/backend/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/backend/libs/simplebar/simplebar.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/backend/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/backend/js/plugins.js') }}"></script>

    <!-- apexcharts -->
    <script data-navigate-once src="{{ asset('assets/backend/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script data-navigate-once src="{{ asset('assets/backend/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/backend/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script data-navigate-once src="{{ asset('assets/backend/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- App js -->
    <script src="{{ asset('assets/backend/js/app.js') }}"></script>

    @stack('scripts')

    @livewireScripts
    <script>
        document.addEventListener('livewire:init', () => {

            // 1. GLOBAL TOASTIFY HANDLER
            window.addEventListener('show-toast', event => {
                // Livewire 3 data is stored in event.detail
                const data = event.detail[0];

                Toastify({
                    text: data.message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                    style: {
                        background: data.type === 'success' ? "#4CAF50" : "#F44336",
                        borderRadius: "8px",
                    },
                }).showToast();
            });

            // 2. GLOBAL MODAL CLOSER
            window.addEventListener('close-modal', () => {
                // Find the currently open modal
                const modalEl = document.querySelector('.modal.show');

                if (modalEl) {
                    // FIX: "aria-hidden" error - Move focus to body before hiding
                    if (document.activeElement) {
                        document.activeElement.blur();
                    }

                    // Hide using Bootstrap 5 Instance
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.hide();

                    // SAFETY CLEANUP: Removes stuck grey backdrops and restores scroll
                    setTimeout(() => {
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        backdrops.forEach(el => el.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }, 400);
                }
            });

            document.addEventListener('hide.bs.modal', function(event) {
                // 1. Immediately move focus away from the button that was clicked
                // This stops the "aria-hidden" error because the button is no longer focused
                if (document.activeElement) {
                    document.activeElement.blur();
                }

                // 2. Move focus to the body to be safe
                document.body.focus();

                // 3. For Livewire safety: manually remove the attribute that causes the error
                // as the modal begins to close
                event.target.removeAttribute('aria-hidden');
            });

        });
    </script>
</body>


</html>