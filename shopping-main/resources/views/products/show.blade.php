@extends('layouts.app') 

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        {{ $product->name }}
                    </div>

                    <div class="card-body">
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
                                                <p>Description: {{ $product->description }}</p>
                        <p>Price: {{ $product->price }}</p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
