@extends(getLayoutNameMultiReturnDefaultIfNull())


@section('title')
    <?php
    echo \App\Models\SiteMng::getTitle();
    ?>

@endsection

@section('meta-description')<?php
                            echo \App\Models\SiteMng::getDesc()
                            ?>
@endsection

@section('meta-keywords')<?php
                         echo \App\Models\SiteMng::getKeyword()
                         ?>
@endsection

@section('content')

    <style>
        .tinh-nang{
            height: 350px;
        }
        .card-body h4 {
            text-align: center;
        }
        .card-body svg {
            display: block;
            margin: 0 auto;
        }
    </style>

    <section class="wrapper bg-gradient-primary">
        <div class="container pt-10 pt-md-14 pb-8 text-center">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
                <div class="col-lg-7">
                    <figure><img class="w-auto" src="/template/sandbo/assets/img/concept/concept2.png" srcset="/template/sandbo/assets/img/concept/concept2@2x.png 2x" alt="" /></figure>
                </div>
                <!-- /column -->
                <div class="col-md-10 offset-md-1 offset-lg-0 col-lg-5 text-center text-lg-start">
                    <h1 class="display-1 mb-5 mx-md-n5 mx-lg-0">Dịch vụ lưu trữ & chia sẻ file hàng đầu.</h1>
                    <p class="lead fs-lg mb-7">
                        Upload , download, backup, chia sẻ file mọi lúc mọi nơi.
                    </p>
                    <span><a class="btn btn-primary rounded-pill me-2">Try It For Free</a></span>
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
    <section class="wrapper bg-light">
        <div class="container pt-6 pt-md-6">
            <div class="row text-center">
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
{{--                    <h2 class="fs-16 text-uppercase text-muted mb-3">Tính năng chính</h2>--}}
{{--                    <h3 class="display-4 mb-10 px-xl-10">The service we offer is specifically designed to meet your needs.</h3>--}}
                    <h3 class="display-4 mb-10 px-xl-10">Tính năng chính</h3>

                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
            <div class="position-relative">
                <div class="shape rounded-circle bg-soft-blue rellax w-16 h-16" data-rellax-speed="1" style="bottom: -0.5rem; right: -2.2rem; z-index: 0;"></div>
                <div class="shape bg-dot primary rellax w-16 h-17" data-rellax-speed="1" style="top: -0.5rem; left: -2.5rem; z-index: 0;"></div>
                <div class="row gx-md-5 gy-5 ">
                    <div class="col-md-6 col-xl-3">
                        <div class="card flex-grow-1 shadow-lg tinh-nang">
                            <div class="card-body">
                                <img src="/template/sandbo/assets/img/icons/search-1.svg" class="svg-inject icon-svg icon-svg-md text-yellow mb-3" alt="" />
                                <h4>Upload File</h4>
                                <p class="mb-2">
                                    <i class="uil uil-check fs-21"></i><span>Dung lượng từng File lên tới 100G</span></li>
                                </p>
                                <p class="mb-2">
                                    <i class="uil uil-check fs-21"></i><span>Tài khoản lưu trữ lên tới trên 100TB </span></li>
                                </p>

                            </div>
                            <!--/.card-body -->
                        </div>
                        <!--/.card -->
                    </div>
                    <!--/column -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card flex-grow-1  shadow-lg tinh-nang">
                            <div class="card-body">
                                <img src="/template/sandbo/assets/img/icons/browser.svg" class="svg-inject icon-svg icon-svg-md text-red mb-3" alt="" />
                                <h4>Tool Upload</h4>
                                <p class="mb-2">
                                    <i class="uil uil-check fs-21"></i> Upload resume - Up tiếp file lớn nếu chưa thành công
                                </p>
                                <p class="mb-2">
                                    <i class="uil uil-check fs-21"></i>Xem Video với Tool mà không cần tải về
                                </p>

                            </div>
                            <!--/.card-body -->
                        </div>
                        <!--/.card -->
                    </div>
                    <!--/column -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card flex-grow-1  shadow-lg  tinh-nang">
                            <div class="card-body">
                                <img src="/template/sandbo/assets/img/icons/chat-2.svg" class="svg-inject icon-svg icon-svg-md text-green mb-3" alt="" />
                                <h4>Tải file</h4>
                                <p class="mb-2">
                                    <i class="uil uil-check fs-21"></i>
                                Tốc độ không bị giới hạn với TK VIP
                                </p>
                                <p class="mb-2">
                                    <i class="uil uil-check fs-21"></i>
                                    Hỗ trợ tải đa luồng
                                </p>

                            </div>
                            <!--/.card-body -->
                        </div>
                        <!--/.card -->
                    </div>
                    <!--/column -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card flex-grow-1  shadow-lg  tinh-nang">
                            <div class="card-body">
                                <img src="/template/sandbo/assets/img/icons/megaphone.svg" class="svg-inject icon-svg icon-svg-md text-blue mb-3" alt="" />
                                <h4>Tìm kiếm File chia sẻ</h4>
                                <p class="mb-2">
                                    <i class="uil uil-check fs-21"></i>
                                Tìm hàng chục triệu file đã được chia sẻ
                                </p>
                                <p class="mb-2">
                                    <i class="uil uil-check fs-21"></i>
                                    Tìm Kiếm AI - thông minh với Bộ siêu lọc chỉ có tại 4Share
                                </p>
                            </div>
                            <!--/.card-body -->
                        </div>
                        <!--/.card -->
                    </div>
                    <!--/column -->
                </div>
                <!--/.row -->
            </div>
            <!-- /.position-relative -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->

    <section class="wrapper image-wrapper bg-image bg-overlay"
             data-image-src="/template/sandbo/assets/img/server-background5.png" style="background-image:
             url('/template/sandbo/assets/img/server-background5.png');">
        <div class="container py-10 py-md-12 white-all-text mt-10" style="">
            <div class="row">
                <div class="col-xl-10 mx-auto">
                    <div class="row align-items-center counter-wrapper gy-6 text-center">
                        <div class="col-md-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.6 409.6" data-inject-url="https://galaxycloud.vn/template/glx2021/assets/img/icons/check.svg" class="svg-inject icon-svg icon-svg-lg text-primary mb-3"><path class="svg-stroke" d="M204.8 409.6C91.9 409.6 0 317.7 0 204.8c0-49.9 18.2-98.1 51.2-135.5 4.4-5 12-5.5 17-1.1s5.5 12 1.1 17c-29.1 33-45.2 75.5-45.2 119.5 0 99.6 81.1 180.7 180.7 180.7s180.7-81.1 180.7-180.7S304.4 24.1 204.8 24.1c-27.3-.1-54.2 6.1-78.7 18-6 2.9-13.2.4-16.1-5.6-2.9-6-.4-13.2 5.6-16.1C143.4 6.9 173.9-.1 204.8 0c112.9 0 204.8 91.9 204.8 204.8s-91.9 204.8-204.8 204.8z"></path><path class="svg-fill" d="M349.4 204.8c0 79.8-64.7 144.6-144.6 144.6S60.2 284.6 60.2 204.8 125 60.2 204.8 60.2 349.4 125 349.4 204.8z"></path><path class="svg-stroke" d="M204.8 361.4c-86.4 0-156.6-70.2-156.6-156.6S118.4 48.2 204.8 48.2s156.6 70.2 156.6 156.6-70.2 156.6-156.6 156.6zm0-289.1c-73.1 0-132.5 59.4-132.5 132.5s59.4 132.5 132.5 132.5 132.5-59.5 132.5-132.5S277.9 72.3 204.8 72.3z"></path><path class="svg-stroke" d="M200.9 246.7c-8.8 0-17.2-3.5-23.5-9.7L145 204.5c-4.7-4.7-4.7-12.3 0-17s12.3-4.7 17 0l32.5 32.5c3.6 3.5 9.3 3.5 12.8 0l49.8-49.9c4.7-4.7 12.3-4.7 17 0s4.7 12.3 0 17L224.4 237c-6.2 6.2-14.7 9.7-23.5 9.7z"></path></svg>
                            <h3 class="counter" style="visibility: visible;"><?php echo  (5000 + rand(1000,5000)) ?></h3>
                            <p>User Online</p>
                        </div>
                        <!--/column -->
                        <div class="col-md-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 441.4 512" data-inject-url="https://galaxycloud.vn/template/glx2021/assets/img/icons/user.svg" class="svg-inject icon-svg icon-svg-lg text-primary mb-3"><path class="svg-fill" d="M254.9 457c-14.9-8.1-24.1-23.7-24.1-40.6V285.6c26.5 11.1 57.1 4.9 77.1-15.6-19-26.2-49.3-41.6-81.6-41.6H115.7c-55.7 0-100.9 45.2-100.9 100.9v167.9h312.4v-.8L254.9 457z"></path><path class="svg-stroke" d="M426.6 270.8c-8.2 0-14.8 6.6-14.9 14.8v130.7c0 11.5-6.3 22.1-16.4 27.6l-66.7 36.3-66.6-36.3c-10.1-5.5-16.4-16.1-16.4-27.6V305c4.1.6 8.2.9 12.3.9 1.3 0 2.5 0 3.8-.1h1c1.1-.1 2.2-.1 3.4-.2l1.6-.2 1.6-.2c15-2 29.3-8 41.1-17.5l1.1-.9 1.3-1.1c.9-.7 1.7-1.5 2.5-2.2l.4-.4c1-.9 1.9-1.8 2.8-2.7 3.8-3.9 7.2-8.1 10.1-12.6 7.2 10.9 16.8 19.9 28 26.5 7.1 4.1 16.2 1.8 20.3-5.3 4.1-7.1 1.8-16.2-5.3-20.3-10-5.9-17.9-14.8-22.6-25.5-2.4-5.4-7.7-8.8-13.6-8.9h-13.5c-5.9 0-11.2 3.5-13.6 8.9-.5 1-.9 2-1.4 3-12.8-12.4-28.4-21.7-45.4-27.2 17.4-16.5 27.2-39.4 27.2-63.3V87.5c-.2-8.2-7-14.7-15.2-14.5-7.9.2-14.3 6.6-14.5 14.5v68.3c0 31.6-25.5 57.4-57.1 57.8h-62c-31.6-.5-57-26.2-57-57.8V87.5c0-31.9 25.9-57.8 57.8-57.8h60.5c8.2-.2 14.7-7 14.5-15.2-.2-7.9-6.6-14.3-14.5-14.5h-60.5C92.5.1 53.3 39.2 53.3 87.5v68.3c0 23.9 9.8 46.8 27.2 63.3C32.6 234.5.1 279 0 329.3v167.9c0 8.2 6.6 14.8 14.8 14.8h313.9c2.5 0 4.9-.6 7.1-1.8l73.8-40.2c19.6-10.7 31.9-31.3 31.9-53.6V285.6c-.1-8.2-6.7-14.8-14.9-14.8zM29.7 482.3v-153c.1-47.5 38.5-85.9 86-86h40.4v144.1c0 8.2 6.6 14.8 14.8 14.8s14.8-6.6 14.8-14.8V243.3h40.4c22.6 0 44.3 9 60.4 24.8-6.3 3.9-13.3 6.4-20.6 7.5h.1c-1.1.2-2.3.3-3.5.4l-.6.1c-1.2.1-2.5.1-3.7.1h-.2c-7.3 0-14.6-1.4-21.4-4.3-7.5-3.2-16.3.3-19.4 7.9-.8 1.8-1.2 3.8-1.2 5.8v130.7c0 22.4 12.2 42.9 31.8 53.7l22.6 12.3H29.7z"></path><path class="svg-stroke" d="M327.2 405.9c-2.5 0-5-.6-7.2-1.9l-24.9-13.9c-7.2-4-9.7-13-5.7-20.2s13-9.7 20.2-5.7l15.7 8.7 34.1-30.1c6.1-5.4 15.5-4.9 21 1.3 5.4 6.1 4.9 15.5-1.3 21l-42 37.1c-2.8 2.4-6.3 3.7-9.9 3.7z"></path></svg>
                            <h3 class="counter" style="visibility: visible;">12.000.000</h3>
                            <p>Satisfied Customers</p>
                        </div>
                        <!--/column -->
                        <div class="col-md-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.6 380.8" data-inject-url="https://galaxycloud.vn/template/glx2021/assets/img/icons/briefcase-2.svg" class="svg-inject icon-svg icon-svg-lg text-primary mb-3"><path class="svg-stroke" d="M299.9 104.7h-23.8V56.5c0-18.1-14.6-32.7-32.7-32.7h-77.2c-18 0-32.7 14.7-32.7 32.7v48.2h-23.8V56.5C109.8 25.3 135 0 166.2 0h77.2c31.2 0 56.4 25.3 56.5 56.5v48.2z"></path><path class="svg-stroke" d="M360.5 380.8H49.1c-27.1 0-49-22-49.1-49.1V119.1C0 92 22 70 49.1 70h311.5c27.1 0 49 22 49.1 49.1v212.7c-.1 27.1-22.1 49-49.2 49zM49.1 93.8c-14 0-25.3 11.3-25.3 25.3v212.7c0 14 11.3 25.3 25.3 25.3h311.5c14 0 25.3-11.3 25.3-25.3V119.1c0-14-11.3-25.3-25.3-25.3H49.1z"></path><path class="svg-fill" d="M49.2 81.7c-18.4 0-33.3 14.8-33.3 33.2 0 2.7.3 5.3.9 7.9C35.4 197.9 103.6 254 184.2 254h41.2c80.6 0 148.8-56.1 167.3-131.2 4.3-17.8-6.6-35.8-24.5-40.2-2.6-.6-5.2-.9-7.9-.9H49.2z"></path><path class="svg-stroke" d="M225.4 265.9h-41.2c-41.5-.1-81.8-14.2-114.3-40C38 200.5 15.3 165.2 5.4 125.6-.5 101.4 14.3 77 38.6 71.1c3.5-.9 7.1-1.3 10.7-1.3h311.1c24.9 0 45.2 20.2 45.2 45.1 0 3.6-.4 7.2-1.3 10.7-9.9 39.6-32.6 74.8-64.5 100.2-32.6 25.9-72.9 40-114.4 40.1zM49.2 93.6c-6.6 0-12.9 3-16.9 8.2-4.1 5.1-5.5 11.8-3.9 18.2 17.6 71.8 81.9 122.3 155.8 122.2h41.2c73.9.1 138.3-50.4 155.8-122.2 1.6-6.3.1-13-3.9-18.1-4.1-5.2-10.3-8.3-16.9-8.2l-311.2-.1z"></path><path class="svg-fill" d="M128.5 288.5h-13.8c-8.9 0-16.1-7.2-16.1-16.1v-48.3c0-8.9 7.2-16.1 16.1-16.1h13.8c8.9 0 16.1 7.2 16.1 16.1v48.3c0 8.9-7.2 16.1-16.1 16.1z"></path><path class="svg-stroke" d="M128.5 300.4h-13.8c-15.5 0-28-12.5-28-28v-48.3c0-15.5 12.5-28 28-28h13.8c15.5 0 28 12.5 28 28v48.3c0 15.5-12.5 28-28 28zm-13.8-80.5c-2.3 0-4.2 1.9-4.2 4.2v48.3c0 2.3 1.9 4.2 4.2 4.2h13.8c2.3 0 4.2-1.9 4.2-4.2v-48.3c0-2.3-1.9-4.2-4.2-4.2h-13.8z"></path><path class="svg-fill" d="M294.9 288.5h-13.8c-8.9 0-16.1-7.2-16.1-16.1v-48.3c0-8.9 7.2-16.1 16.1-16.1h13.8c8.9 0 16.1 7.2 16.1 16.1v48.3c0 8.9-7.2 16.1-16.1 16.1z"></path><path class="svg-stroke" d="M294.9 300.4h-13.8c-15.5 0-28-12.5-28-28v-48.3c0-15.5 12.5-28 28-28h13.8c15.5 0 28 12.5 28 28v48.3c0 15.5-12.5 28-28 28zm-13.8-80.5c-2.3 0-4.2 1.9-4.2 4.2v48.3c0 2.3 1.9 4.2 4.2 4.2h13.8c2.3 0 4.2-1.9 4.2-4.2v-48.3c0-2.3-1.9-4.2-4.2-4.2h-13.8z"></path></svg>
                            <h3 class="counter" style="visibility: visible;">500 Gbs</h3>
                            <p>Bandwidth usage</p>
                        </div>
                        <!--/column -->
                        <div class="col-md-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.6 404.7" data-inject-url="https://galaxycloud.vn/template/glx2021/assets/img/icons/award-2.svg" class="svg-inject icon-svg icon-svg-lg text-primary mb-3"><path class="svg-stroke" d="M90.8 404.7c-6.5 0-12.4-4-14.7-10.1L57.7 347 10 328.7c-8.1-3.1-12.2-12.2-9-20.4.8-2 2-3.9 3.5-5.5l93.6-93.6 97.3 97.3-93.6 93.6c-2.9 2.9-6.9 4.6-11 4.6zm-60.7-93.8l39.5 15.2c4.1 1.6 7.4 4.9 9 9l15.2 39.5 68.1-68.1-63.7-63.7-68.1 68.1zm288.7 93.8c-4.2 0-8.2-1.7-11.1-4.6l-20.8-20.8 16.8-16.8 12.1 12.1 15.2-39.5c1.6-4.1 4.9-7.4 9-9l39.4-15.2-76.4-76.5 16.8-16.8 85.2 85.2c6.1 6.1 6.1 16.1 0 22.3-1.6 1.6-3.4 2.8-5.5 3.6L351.9 347l-18.3 47.6c-1.9 5-6.2 8.7-11.4 9.8-1.1.2-2.2.3-3.4.3z"></path><path class="svg-fill" d="M347.3 224.1c5.1-15.7 31-28.9 31-46.3s-25.9-30.6-31-46.3c-5.3-16.3 7.8-42.2-2.1-55.7s-38.6-9.2-52.4-19.2-18-38.6-34.4-43.9C242.7 7.6 222.2 28 204.8 28s-37.9-20.4-53.6-15.3c-16.3 5.3-20.8 34-34.4 43.9s-42.4 5.5-52.4 19.2 3.2 39.4-2.1 55.7c-5.1 15.7-31.1 28.8-31.1 46.3s25.9 30.6 31 46.3c5.3 16.3-7.8 42.1 2.1 55.7S103 289 116.7 299s18.1 38.6 34.4 43.9c15.7 5.1 36.2-15.3 53.6-15.3s37.9 20.4 53.6 15.3c16.3-5.3 20.8-34 34.4-43.9s42.4-5.5 52.4-19.2-3.1-39.3 2.2-55.7zm-142.5 48.7c-52.5 0-95-42.5-95-95s42.5-95 95-95 95 42.5 95 95-42.5 95-95 95z"></path><path class="svg-stroke" d="M253 355.7c-10.1 0-19.6-4.6-28.8-9.1-7-3.4-14.3-7-19.4-7s-12.4 3.6-19.4 7c-9.2 4.5-18.7 9.1-28.8 9.1-3.1 0-6.2-.5-9.1-1.4-13.7-4.5-20.7-17.6-26.8-29.2-3.5-6.7-7.2-13.6-10.9-16.3s-11.6-4.2-19.2-5.5c-12.8-2.2-27.4-4.8-35.8-16.3s-6.3-26-4.5-38.8c1.1-7.6 2.2-15.6.7-20.2-1.4-4.2-6.7-9.8-11.9-15.1-9.2-9.5-19.7-20.2-19.7-34.9s10.5-25.4 19.7-34.9c5.2-5.3 10.6-10.8 12-15.1 1.5-4.7.4-12.6-.7-20.2C48.6 95 46.5 80.4 54.8 69s23-14.1 35.8-16.3c7.5-1.3 15.3-2.7 19.2-5.5s7.4-9.6 10.9-16.3c6.1-11.6 13.1-24.8 26.8-29.2 2.9-1 6-1.4 9.1-1.4 10.1 0 19.6 4.6 28.8 9.1 7 3.4 14.3 7 19.4 7s12.4-3.6 19.4-7C233.4 4.6 243 0 253 0c3.1 0 6.2.5 9.1 1.4 13.7 4.5 20.7 17.6 26.8 29.2 3.5 6.7 7.2 13.6 10.9 16.3s11.6 4.2 19.2 5.5c12.9 2.2 27.4 4.8 35.8 16.3s6.3 26 4.5 38.8c-1.1 7.6-2.2 15.6-.7 20.2 1.4 4.2 6.7 9.8 11.9 15.1 9.2 9.5 19.7 20.2 19.7 34.9s-10.5 25.4-19.7 34.9c-5.2 5.3-10.6 10.9-11.9 15.1-1.5 4.7-.4 12.6.7 20.2 1.8 12.9 3.9 27.4-4.5 38.8s-23 14.1-35.8 16.3c-7.5 1.3-15.3 2.7-19.2 5.5s-7.4 9.6-10.9 16.3c-6.1 11.6-13.1 24.8-26.8 29.2-2.9 1.2-6 1.7-9.1 1.7zm-48.2-39.9c10.6 0 20.4 4.8 29.8 9.4 6.8 3.3 13.8 6.7 18.4 6.7.6 0 1.2-.1 1.7-.2 4.5-1.5 9.1-10.1 13.1-17.8 4.8-9.1 9.8-18.5 18-24.5s18.9-7.9 29.1-9.7c8.4-1.5 18-3.1 20.7-6.9s1.3-13.2.1-21.6c-1.4-10.3-2.9-21 .3-30.8 3.1-9.5 10.4-17 17.5-24.3 6.1-6.2 13-13.3 13-18.3s-6.9-12.1-13-18.3c-7.1-7.3-14.4-14.8-17.5-24.3-3.2-9.9-1.7-20.5-.3-30.8 1.2-8.4 2.5-17.9-.1-21.6s-12.3-5.4-20.7-6.9c-10.2-1.8-20.8-3.6-29.1-9.7s-13.2-15.4-18-24.5c-4-7.6-8.6-16.3-13.1-17.8-.6-.2-1.2-.3-1.8-.2-4.6 0-11.6 3.4-18.4 6.7-9.5 4.6-19.3 9.4-29.8 9.4s-20.4-4.8-29.8-9.4c-6.8-3.3-13.8-6.7-18.4-6.7-.6 0-1.2.1-1.8.2-4.5 1.5-9.1 10.1-13.1 17.8-4.8 9.1-9.8 18.5-18 24.5s-18.9 7.9-29.1 9.7c-8.4 1.5-18 3.2-20.7 6.9s-1.3 13.2-.1 21.6c1.4 10.3 2.9 21-.3 30.8-3.1 9.5-10.4 17-17.5 24.3-6 6.2-12.9 13.3-12.9 18.3s6.9 12.1 13 18.3c7.1 7.3 14.4 14.8 17.5 24.3 3.2 9.9 1.7 20.5.3 30.8-1.2 8.4-2.5 17.9.1 21.6s12.3 5.4 20.7 6.9c10.2 1.8 20.8 3.6 29.1 9.7s13.2 15.4 18 24.5c4 7.6 8.6 16.3 13.1 17.7.6.2 1.2.3 1.8.2 4.6 0 11.6-3.4 18.4-6.7 9.5-4.6 19.3-9.3 29.8-9.3z"></path><path class="svg-stroke" d="M204.8 284.7c-59 0-106.9-47.9-106.9-106.9 0-59 47.9-106.9 106.9-106.9 59 0 106.9 47.8 106.9 106.8v.1c-.1 59-47.9 106.9-106.9 106.9zm0-190c-45.9 0-83.2 37.2-83.2 83.1 0 45.9 37.2 83.2 83.1 83.2 45.9 0 83.2-37.2 83.2-83.1 0-25.8-12-50.1-32.4-65.9-14.4-11.2-32.3-17.3-50.7-17.3z"></path></svg>
                            <h3 class="counter" style="visibility: visible;">6500 TBs</h3>
                            <p>Storage usage</p>
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <!-- /section -->
    <section class="wrapper ">
        <div class="container py-8 pt-md-8 pb-md-8">
            <div class="position-relative ">
                <div class="row text-center">
                    <div class="col-lg-6 mx-auto">
                        <h2 class="fs-16 text-uppercase text-muted mb-3">Our Customers</h2>
                        <h3 class="display-4 mb-10">Khách hàng nói về chúng tôi</h3>
                    </div>
                    <!-- /column -->
                </div>
                <!-- /.row -->
                <div class="position-relative">
                    <div class="shape bg-dot blue rellax w-16 h-17" data-rellax-speed="1" style="bottom: 0.5rem; right: -1.7rem; z-index: 0;"></div>
                    <div class="shape rounded-circle bg-line red rellax w-16 h-16" data-rellax-speed="1" style="top: 0.5rem; left: -1.7rem; z-index: 0;"></div>
                    <div class="row grid-view gy-6 gy-xl-0">
                        <div class="col-md-6 col-xl-3">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <img class="rounded-circle w-15 mb-4" src="/template/sandbo/assets/img/avatars/te1.jpg" srcset="/template/sandbo/assets/img/avatars/te1@2x.jpg 2x" alt="" />
                                    <h4 class="mb-1">Mr Phan Anh</h4>
                                    <div class="meta mb-2">Lập trình viên</div>
                                    <p class="mb-2">4Share hỗ trợ API tốt và ổn định, tôi thường sử dụng để CDN file</p>
                                    <nav class="nav social mb-0">
                                        <a href="#"><i class="uil uil-twitter"></i></a>
                                        <a href="#"><i class="uil uil-facebook-f"></i></a>
                                        <a href="#"><i class="uil uil-dribbble"></i></a>
                                    </nav>
                                    <!-- /.social -->
                                </div>
                                <!--/.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/column -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <img class="rounded-circle w-15 mb-4" src="/template/sandbo/assets/img/avatars/te2.jpg" srcset="/template/sandbo/assets/img/avatars/te2@2x.jpg 2x" alt="" />
                                    <h4 class="mb-1">Nuna Phạm</h4>
                                    <div class="meta mb-2">Marketing Specialist</div>
                                    <p class="mb-2">Tôi sử dụng 4Share thường xuyên để gửi file lớn cho khách hàng của mình.</p>
                                    <nav class="nav social mb-0">
                                        <a href="#"><i class="uil uil-twitter"></i></a>
                                        <a href="#"><i class="uil uil-facebook-f"></i></a>
                                        <a href="#"><i class="uil uil-dribbble"></i></a>
                                    </nav>
                                    <!-- /.social -->
                                </div>
                                <!--/.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/column -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <img class="rounded-circle w-15 mb-4" src="/template/sandbo/assets/img/avatars/te3.jpg" srcset="/template/sandbo/assets/img/avatars/te3@2x.jpg 2x" alt="" />
                                    <h4 class="mb-1">Mr Vinh</h4>
                                    <div class="meta mb-2">Sys Admin</div>
                                    <p class="mb-2">4Share sử dụng để backup rất tốt. Dữ liệu của tôi đã lưu 15 năm trên đây</p>
                                    <nav class="nav social mb-0">
                                        <a href="#"><i class="uil uil-twitter"></i></a>
                                        <a href="#"><i class="uil uil-facebook-f"></i></a>
                                        <a href="#"><i class="uil uil-dribbble"></i></a>
                                    </nav>
                                    <!-- /.social -->
                                </div>
                                <!--/.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/column -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <img class="rounded-circle w-15 mb-4" src="/template/sandbo/assets/img/avatars/te4.jpg" srcset="/template/sandbo/assets/img/avatars/te4@2x.jpg 2x" alt="" />
                                    <h4 class="mb-1">An Trần</h4>
                                    <div class="meta mb-2">Người dùng</div>
                                    <p class="mb-2">4Share có kho tìm kiếm độc đáo, tìm cả các file chia sẻ hàng chục năm trước.</p>
                                    <nav class="nav social mb-0">
                                        <a href="#"><i class="uil uil-twitter"></i></a>
                                        <a href="#"><i class="uil uil-facebook-f"></i></a>
                                        <a href="#"><i class="uil uil-dribbble"></i></a>
                                    </nav>
                                    <!-- /.social -->
                                </div>
                                <!--/.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
                </div>
                <!-- /.position-relative -->
            </div>
            <!-- /div -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
    <section class="wrapper bg-light pb-5">
        <div class="container">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
                <div class="col-lg-7 order-lg-2">
                    <figure><img class="w-auto" src="/template/sandbo/assets/img/concept/concept8.png" srcset="/template/sandbo/assets/img/concept/concept8@2x.png 2x" alt="" /></figure>
                </div>
                <!--/column -->
                <div class="col-lg-5">
                    <h2 class="fs-16 text-uppercase text-muted mb-3">Our Solutions</h2>
                    <h3 class="display-4 mb-5">
                        Giải pháp Lưu trữ Big Data
                    </h3>
                    <p class="mb-6">
                    Chúng tôi cung cấp giải pháp lưu trữ Big Data cho cá nhân và doanh nghiệp, giúp họ lưu trữ và xử lý dữ liệu lớn một cách hiệu quả nhất.
                    </p>
                    <div class="row gy-3">
                        <div class="col-xl-6">
                            <ul class="icon-list bullet-bg bullet-soft-primary mb-0">
                                <li><span><i class="uil uil-check"></i></span><span>Sẵn sàng 24/7.</span></li>
                                <li class="mt-3"><span><i class="uil uil-check"></i></span><span>Uptime 99.99%</span></li>
                            </ul>
                        </div>
                        <!--/column -->
                        <div class="col-xl-6">
                            <ul class="icon-list bullet-bg bullet-soft-primary mb-0">
                                <li><span><i class="uil uil-check"></i></span><span>Bảo mật PCI DSS</span></li>
                                <li class="mt-3"><span><i class="uil uil-check"></i></span><span>  Global CDN </span></li>
                            </ul>
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
                </div>
                <!--/column -->
            </div>
            <!--/.row -->
        </div>
        <!-- /.container -->
    </section>

    <style>
        .partner img {
            height: 50px;
            margin: 20px;

        }
        .partner {
            text-align: center;
        }
    </style>
    <section class="wrapper bg-light pb-12 mt-5">
        <div class="container">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
                <div class="col-sm-12 partner">
                    <h2 class="display-4 mb-10 mt-10">Đối tác của chúng tôi</h2>
                    <img src="/images/partner/viettel.png" alt="">
                    <img src="/images/partner/vnpt.png" alt="">
                    <img src="/images/partner/fpt.png" alt="">
                    <img src="/images/partner/samsung.png" alt="">
                    <img src="/images/partner/wd.png" alt="">
                    <img src="/images/partner/dell.png" alt="">
                </div>
            </div>
        </div>
    </section>

@endsection
