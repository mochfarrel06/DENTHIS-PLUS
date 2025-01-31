@extends('user.layouts.master')

@section('content')
    <!-- Team Section -->
    <section id="team" class="team section" style="margin-top: 5em; margin-bottom: 5em">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Dokter Kami</h2>
            <p>
                Necessitatibus eius consequatur ex aliquid fuga eum quidem sint
                consectetur velit
            </p>
        </div>
        <!-- End Section Title -->

        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="member">
                        <img src="{{ asset('assets/user/img/team/team-1.jpg') }}" class="img-fluid" alt="" />
                        <h4>Walter White</h4>
                        <span>Web Development</span>
                        <div class="social">
                            <a href=""><i class="bi bi-twitter-x"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <!-- End Team Member -->
            </div>
        </div>
    </section>
    <!-- /Team Section -->
@endsection
