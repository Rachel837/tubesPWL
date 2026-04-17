@extends('layouts.master')

@section('content')
    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="single_slider  d-flex align-items-center slider_bg_1 overlay">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            <div class="shape_1 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                                <img src="{{ asset('assets/img/shape/shape_1.svg') }}" alt="">
                            </div>
                            <div class="shape_2 wow fadeInDown" data-wow-duration="1s" data-wow-delay=".2s">
                                <img src="{{ asset('assets/img/shape/shape_2.svg') }}" alt="">
                            </div>
                            <span class="wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">Discover The Best Events</span>
                            <h3 class="wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".4s">EventCon 2026</h3>
                            <p class="wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".5s">Join us for extraordinary experiences</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider_area_end -->

    <!-- about_area_start  -->
    <div class="about_area black_bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section_title text-center mb-80">
                        <h3 class="wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s" >About Our Platform</h3>
                        <p class="wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s" >Discover and participate in various exciting events near you. Build connections and create memories together.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about_area_end  -->

    <!-- events_area_start -->
    <div class="program_details_area detials_bg_1 overlay2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title text-center mb-80  wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                        <h3>Upcoming Events</h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="program_detail_wrap">
                        @forelse($events as $event)
                        <div class="single_propram">
                            <div class="inner_wrap">
                                <div class="circle_img"></div>
                                <div class="porgram_top">
                                    <span class=" wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".3s">
                                        @if($event->eventDetails->first())
                                            {{ \Carbon\Carbon::parse($event->eventDetails->first()->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->eventDetails->first()->time_end)->format('H:i') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($event->date_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->date_end)->format('H:i') }}
                                        @endif
                                    </span>
                                    <h4 class=" wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">{{ \Carbon\Carbon::parse($event->date_start)->format('d M Y') }}</h4>
                                </div>
                                <div class="thumb wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
                                    <img src="{{ $event->banner ? asset('storage/'.$event->banner) : asset('assets/img/program_details/1.png') }}" alt="" style="width: 70px; height: 70px; object-fit: cover; border-radius: 50%;">
                                </div>
                                <div class="wow fadeInUp d-flex flex-column" data-wow-duration="1s" data-wow-delay=".6s">
                                    <h4>{{ $event->nama_event }}</h4>
                                    <span style="color:#A0A0A0; font-size: 14px;"><i class="ti-location-pin"></i> {{ $event->location }} | <i class="ti-ticket"></i> Kategori: {{ $event->category->nama_kategori ?? 'Umum' }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                            <h4 class="text-white">Saat ini belum ada event aktif yang tersedia.</h4>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- events_area_end -->

@endsection
