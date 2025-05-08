@extends('frontend.layouts.app')
@section('content')
    @php $lang = get_system_language()->code;  @endphp
    <!-- Sliders -->
    <style>
        .home-banner-area .col-lg-3.d-lg-block video {
    height: 100%; /* Ensure the video fills the entire column */
    max-height: 280px; /* Match the slider height */
    object-fit: cover; /* Maintain aspect ratio without stretching */
}

    </style>
    
    
    <div class="home-banner-area mb-3" style="overflow-x:hidden">
        <div class="container">
            <div class="row">
                
                <!-- Sliders (Always visible) -->
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="d-flex">
                        <!-- Sliders -->
                        <div class="h-100 w-100">
                            @if (get_setting('home_slider_images') != null)
                                <div class="aiz-carousel dots-inside-bottom" data-autoplay="true" data-infinite="true"  data-arrows="true">
                                    @php
                                        $decoded_slider_images = json_decode(get_setting('home_slider_images', null, $lang), true);
                                        $sliders = get_slider_images($decoded_slider_images);
                                    @endphp
                                    @foreach ($sliders as $key => $slider)
                                        <div class="carousel-box">
                                            <a href="{{ json_decode(get_setting('home_slider_links'), true)[$key] }}">
                                                <!-- Image -->
                                                <img class="img-fluid d-block w-100 mw-100 overflow-hidden h-150px h-md-280px h-lg-280px"
                                                    src="{{ $slider ? my_asset($slider->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                                    alt="{{ env('APP_NAME') }} promo"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            
                {{-- <!-- Sidebar image (Visible on desktop only) -->
                <div class="col-lg-3 d-none d-lg-block">
                    <iframe class="h-md-280px" width="100%" src="https://drive.google.com/file/d/1qjKkps2fZta9j8b7DqHsgFoGQ_8j1cOS/preview" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div> --}}

                <!-- Sidebar video (Visible on desktop only) -->
              {{--  <div class="col-lg-3 d-none d-lg-block">
                    <iframe class="h-md-280px" width="100%"
                            src="https://drive.google.com/file/d/{{ $googleDriveFileId }}/preview"
                            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>--}}
                <div class="col-lg-3 d-none d-lg-block">
                    <video class="h-md-280px w-100" autoplay muted loop>
                        <source src="{{ static_asset('assets/video/CPLExpressbdBannerside.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>


            </div>
        </div>
    </div>

    <!--Top Categories -->
    <div id="top_category" class="mb-2 mb-md-3 mt-2 mt-md-3">
        <section class="">
            <div class="container">
                <!-- Title -->
                <div class="pb-2">
                <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                    <span class="">{{ translate('Top Categories') }}</span>
                </h3>
                </div>

                <div style="border: 1px solid #f3f3f3;">
                    <div class="c-scrollbar-light overflow-hidden px-5 pt-3 pb-3">
                        <div class="h-100 d-flex flex-column justify-content-center">
                            <div class="top-category-slick aiz-carousel" data-items="8" data-xxl-items="8" data-xl-items="8" data-lg-items="6" data-md-items="5" data-sm-items="3" data-xs-items="3" data-arrows="true" data-dots="false" data-autoplay="true" data-infinite="true" data-autoplay-speed="1500">
                                @foreach (get_categories() as $key => $category)
                                    <div class="carousel-box h-100 p-2">
                                        <a href="{{ route('category_wise_products', $category['ExternalId']) }}?name={{ urlencode($category['Name']) }}" class="h-100 overflow-hidden hov-scale-img mx-auto" title="{{ ucwords($category->CustomName) }}">
                                            <!-- Image -->
                                            <div class="img h-70px w-70px h-md-80px w-md-80px rounded overflow-hidden mx-auto">
                                                <img class="lazyload img-fit m-auto has-transition"
                                                    src="{{ uploaded_asset($category->banner) ?? static_asset('assets/img/placeholder.jpg')}}" alt="{{ $category->CustomName }}">
                                            </div>
                                            <!-- Title -->
                                            <div class="fs-14 fs-sm-12 mt-3 text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">
                                                <span class="d-block text-dark fw-700">{{ \Illuminate\Support\Str::limit($category->CustomName ?? '..', 15) }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
    </div>

    <!-- Featured Products -->
    <div id="section_featured">
        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                <!-- Top Section -->
                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                    <!-- Title -->
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="">{{ translate('CPL Desired Products') }}</span>
                    </h3>
                    <!-- Links -->
                    <div class="d-flex">
                        <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2" onclick="clickToSlide('slick-prev','section_featured')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                        <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_featured')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                    </div>
                </div>
                <!-- Products Section -->
                <div class="px-sm-3">
                    <div class="aiz-carousel sm-gutters-16 arrow-none" data-items="5" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='false'>
                        @foreach ($featuredProducts as $key => $product)
          
                         <div class=" position-relative px-0 has-transition">
                                <div class="px-1 mb-3 custom-product-box">
                                    @include('frontend.'.get_setting('homepage_select').'.partials.product_box',['product' => $product])
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>   
    </div>
    

    <div id="category_wise_products">
        @foreach ($categoriesWithProducts as $category_key => $category)
            @php
                $categoryName =
                    $category['id'] === 'otc-10'
                        ? 'Bag\'s'
                        : ($category['id'] === 'otc-18'
                            ? 'Snekers'
                            : ($category['id'] === 'otc-13'
                                ? 'Shirt\'s'
                                : ''));
            @endphp
            <section class="mb-2 mb-md-3 mt-2 mt-md-3">
                <div class="container px-1">
                    <!-- Top Section -->
                    <div class="d-flex p-2 mb-3 mb-md-4 border-bottom align-items-baseline justify-content-between">
                        <!-- Title -->
                        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                            <span class="">{{ $categoryName }}</span>
                        </h3>
                        <!-- Links -->
                        <div class="d-flex">
                            <form action="{{ route('category_wise_products', ['category' => $category['id']]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="subcategoryId" value="{{ $category['subcategoryId'] }}">
                                <button type="submit" class="btn text-danger fs-16 fs-md-16 fw-700 hov-text-danger animate-underline-primary">
                                    View All 
                                </button>
                            </form>
                        </div>

                    </div>
                    <!-- Products Section -->
                  

                    
                    <!-- Products Section -->
                    <div class="row mx-2">
                        @foreach ($category['items'] as $product)
                            <div class="col-5-custom position-relative px-0 has-transition hov-animate-outline">
                                <div class="px-1 mb-3 custom-product-box">
                                    @include('frontend.'.get_setting('homepage_select').'.partials.product_box',['product' => $product])
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endforeach
    </div>

    <!-- Banner Section 3 -->
    @php $homeBanner3Images = get_setting('home_banner3_images', null, $lang);   @endphp
    @if ($homeBanner3Images != null)
        <div class="mb-2 mb-md-3 mt-2 mt-md-3" style="overflow-x:hidden">
            <div class="container">
                @php
                    $banner_3_imags = json_decode($homeBanner3Images);
                    $data_md = count($banner_3_imags) >= 2 ? 2 : 1;
                @endphp
                <div class="aiz-carousel overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                    data-items="{{ count($banner_3_imags) }}" data-xxl-items="{{ count($banner_3_imags) }}"
                    data-xl-items="{{ count($banner_3_imags) }}" data-lg-items="{{ $data_md }}"
                    data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true"
                    data-dots="false">
                    @foreach ($banner_3_imags as $key => $value)
                        <div class="carousel-box overflow-hidden hov-scale-img">
                            <a href="{{ json_decode(get_setting('home_banner3_links'), true)[$key] }}"
                                class="d-block text-reset overflow-hidden">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                    data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                                    class="img-fluid lazyload w-100 has-transition"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

 <div id="category_wise_products2">
        @foreach ($categoriesWithProductsSection2 as $category_key => $category)
            @php
                $categoryName =
                    $category['id'] === 'otc-23'
                        ? 'Accessories'
                        : ($category['id'] === 'otc-19'
                            ? 'Cosmetics'
                                : '');
            @endphp
            <section class="mb-2 mb-md-3 mt-2 mt-md-3">
                <div class="container px-1">
                    <!-- Top Section -->
                    <div class="d-flex p-2 mb-3 mb-md-4 border-bottom align-items-baseline justify-content-between">
                        <!-- Title -->
                        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                            <span class="">{{ $categoryName }}</span>
                        </h3>
                        <!-- Links -->
                        <div class="d-flex">
                            <!--<a class="text-danger fs-16 fs-md-16 fw-700 hov-text-danger animate-underline-primary"-->
                            <!--    href="{{ route('category_wise_products', $category['subcategoryId']) }}">View All</a>-->
                             <form action="{{ route('category_wise_products', ['category' => $category['id']]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="subcategoryId" value="{{ $category['subcategoryId'] }}">
                                <button type="submit" class="btn text-danger fs-16 fs-md-16 fw-700 hov-text-danger animate-underline-primary">
                                    View All 
                                </button>
                            </form>
                        
                        </div>
                    </div>
                    <!-- Products Section -->
                  

                    
                    <!-- Products Section -->
                    <div class="row mx-2">
                        @foreach ($category['items'] as $product)
                            <div class="col-5-custom position-relative px-0 has-transition hov-animate-outline">
                                <div class="px-1 mb-3 custom-product-box">
                                    @include('frontend.'.get_setting('homepage_select').'.partials.product_box',['product' => $product])
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endforeach
    </div>
@php 
    $homeBanner1Images = get_setting('home_banner1_images', null, $lang);   
@endphp
@if ($homeBanner1Images != null)
    <div class="mb-2 mb-md-3 mt-2 mt-md-3" style="overflow-x:hidden">
        <div class="container">
            @php
                $banner_1_imags = json_decode($homeBanner1Images);
                $homeBannerLinks = json_decode(get_setting('home_banner1_links'), true);
            @endphp
 <div class="row mx-n1 mx-lg-n2">
    @foreach ($banner_1_imags as $key => $value)
        @if ($key < 2)
            <!-- First Two Images -->
            <div class="col-6 col-lg-3 px-1 px-lg-2">
                <a href="{{ $homeBannerLinks[$key] }}" class="d-block text-reset overflow-hidden">
                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                        data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                        class="img-fluid lazyload w-100 has-transition"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                </a>
            </div>
        @elseif ($key == 2)
            <!-- Last Image -->
            <div class="col-12 col-lg-6 mt-2 mt-lg-0 px-1 px-lg-2">
                <a href="{{ $homeBannerLinks[$key] }}" class="d-block text-reset overflow-hidden">
                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                        data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                        class="img-fluid lazyload w-100 has-transition"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                </a>
            </div>
        @endif
    @endforeach
</div>


        </div>
    </div>
@endif



    <section class="mb-2 mb-md-3 pt-5 mt-md-3">
        <div class="container">
            <!-- Top Section -->
            <div class="text-center">
                <h3 class="fw-700 mb-sm-0">
                    <span class="">{{ translate('How CPL Express Works') }}</span>
                </h3>
            </div>
    
            <div class="bg-white py-3 d-flex justify-content-center flex-wrap">
                <!-- Flowchart for mobile -->
                <div class="flowchart-box">
                    <img src="{{ static_asset('assets/img/Flowchart.gif') }}" class="lazyload w-100 h-auto"
                        alt="Flowchart for Mobile">
                </div>
    
                <!-- Original images with text for larger screens -->
                <div class="icon-box text-center mb-3 mx-2">
                    <img src="{{ static_asset('assets/img/Order Placement.png') }}"
                        class="lazyload w-100px h-auto mx-auto has-transition" alt="Order Placement">
                    <div class="fs-16 mt-2 text-wrap">
                        <span class="text-dark fw-700">Order Placement</span>
                    </div>
                </div>
                <div class="icon-box text-center mb-3 mx-2">
                    <img src="{{ static_asset('assets/img/Buying Goods.png') }}"
                        class="lazyload w-100px h-auto mx-auto has-transition" alt="Buying Goods">
                    <div class="fs-16 mt-2 text-wrap">
                        <span class="text-dark fw-700">Buying Goods</span>
                    </div>
                </div>
                <div class="icon-box text-center mb-3 mx-2">
                    <img src="{{ static_asset('assets/img/Goods Received in China warehouse.png') }}"
                        class="lazyload w-100px h-auto mx-auto has-transition" alt="Goods Received in China warehouse">
                    <div class="fs-16 mt-2 text-wrap">
                        <span class="text-dark fw-700">Goods Received in China Warehouse</span>
                    </div>
                </div>
                <div class="icon-box text-center mb-3 mx-2">
                    <img src="{{ static_asset('assets/img/Shipment Done.png') }}"
                        class="lazyload w-100px h-auto mx-auto has-transition" alt="Shipment Done">
                    <div class="fs-16 mt-2 text-wrap">
                        <span class="text-dark fw-700">Shipment Done</span>
                    </div>
                </div>
                <div class="icon-box text-center mb-3 mx-2">
                    <img src="{{ static_asset('assets/img/Goods Received in Bangladesh.png') }}"
                        class="lazyload w-100px h-auto mx-auto has-transition" alt="Goods Received in Bangladesh">
                    <div class="fs-16 mt-2 text-wrap">
                        <span class="text-dark fw-700">Goods Received in Bangladesh</span>
                    </div>
                </div>
                <div class="icon-box text-center mb-3 mx-2">
                    <img src="{{ static_asset('assets/img/Ready to deliver.png') }}"
                        class="lazyload w-100px h-auto mx-auto has-transition" alt="Ready to deliver">
                    <div class="fs-16 mt-2 text-wrap">
                        <span class="text-dark fw-700">Ready to Deliver</span>
                    </div>
                </div>
             
            </div>
        </div>
    </section>
@endsection
