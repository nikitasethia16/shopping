@extends('layouts.app')
@section('content')
<div class="title d-flex justify-content-center align-items-center my-5">
    <a class="text-decoration-none text-dark">
        <h4 class="mx-4 all filter-btn" data-filter="all" style="color: #4a52e4; cursor: pointer;">All</h4>
    </a>
    <a class="text-decoration-none text-dark">
        <h4 class="mx-4 app filter-btn" data-filter="app" style="cursor: pointer;">App</h4>
    </a>
    <a class="text-decoration-none text-dark">
        <h4 class="mx-4 product filter-btn" data-filter="product" style="cursor: pointer;">Product</h4>
    </a>
    <a class="text-decoration-none text-dark">
        <h4 class="mx-4 brand filter-btn" data-filter="branding" style="cursor: pointer;">Branding</h4>
    </a>
    <a class="text-decoration-none text-dark">
        <h4 class="mx-4 books filter-btn" data-filter="books" style="cursor: pointer;">Books</h4>
    </a>
</div>
{{-- <div class="container d-flex justify-content-center align-items-center">
    <div>
    <input type="text" class="border rounded mb-4 " style="width:500px; height:30px">
    <button type="Search " class="py-1 px-1 rounded btn btn-primary">Search</button>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 ">
    <div class="dropdown float-end">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Dropdown button
  </button>
  <ul class="dropdown-menu dropdown-menu-dark">
    <li><a class="dropdown-item active" href="#">Action</a></li>
    <li><a class="dropdown-item" href="#">Another action</a></li>
    <li><a class="dropdown-item" href="#">Something else here</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#">Separated link</a></li>
  </ul>
</div>
    </div>
</div> --}}
    <a href="{{ route('cart.index') }}" class="btn btn-primary mb-3 mx-5"> Go to Cart </a>


<div class="container">
    <div class="row">
        @foreach ($data as $info)
        @php
            $files = [];
            if(is_array($info)) {
                foreach($info as $sinfo) {
                    $files[] = $sinfo['file_path'];
                }
            }
        @endphp

        <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
            <div class="card h-100">
                <div id="carouselExample{{ $loop->index }}" class="carousel slide">
                    <div class="carousel-inner">
                        @if(isset($info->media[0]->file_path))
                            @foreach ($info->media as $key => $media)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                   <a href="{{ route('product.details', ['product_id' => $media->product_id]) }}"><img src="{{ asset('image/' . $media->file_path) }}" class="d-block w-100 carousel-image" alt="Img" ></a> 
                                </div>
                            @endforeach
                        @else
                            <div class="carousel-item active">
                                <img src="{{ asset('image/imgnotavl.png') }}" class="d-block w-100 carousel-image" alt="Img">
                            </div>
                        @endif
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample{{ $loop->index }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample{{ $loop->index }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $info['name'] }}</h5>
                    <p class="card-text">{{ $info['description'] }}</p>
                    <span class="card-text">₹ {{ $info['net_price'] }}</span>
                    <span class="card-text" style="color: grey">
                         <s>{{ $info['price'] }}</s>
                    </span>
                    <span class="card-text" style="color: green"> {{ $info['discount'] }}% Off</span>
                    
                
                    <form action="/cart" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $info->id }}">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
                    </form>
                    
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .carousel-image {
        width: 100%;
        height: 200px; /* Fixed height for images */
        object-fit: contain; /* Ensure image is fully visible */
        background-color: white; /* Add white background to fill space */
        border: 1px solid white; /* Optional white border */
    }

    .card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-radius: 15px; /* Add border radius */
        overflow: hidden; /* Ensure rounded corners are visible */
    }

    .carousel {
        max-height: 200px; /* Ensure carousel height is consistent */
    }
    .carousel-control-prev, .carousel-control-next{
        fill: black;
    }
</style>

<script>
// Get all filter buttons
    const filterButtons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.cardImage');
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filterValue = button.getAttribute('data-filter');
            cards.forEach(card => {
                if (filterValue === 'all' || card.id === filterValue) {
                    card.style.display = 'grid';
                    card.classList.add('show-animation');
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    </script>
@endsection
