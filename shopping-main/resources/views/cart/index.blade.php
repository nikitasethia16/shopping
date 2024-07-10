@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <h4>Shopping Cart</h4>
            @if (true)
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        $gtotal=0;
                        @endphp 
                        @foreach ($cartd as  $details)
                        {{-- @dd($details['product']['media']['file_path']); --}}
                        
                            @php
                            $gtotal+=$details['product']['net_price'] * $details['quantity'];
                            $id=$details['id'];
                            $idp=$details['product_id'];
                            // print_r($idp);

                                $imagePath = file_exists(public_path('image/' . $details['product']['media'][0]['file_path'])) ? asset('image/' . $details['product']['media'][0]['file_path']) : asset('image/imgnotavl.png');
                            @endphp
                            
                            <tr data-id="{{ $id }}" id="tr_{{$id}}">
                                <td>
                                    <img src="{{ $imagePath }}" width="50" height="50" class="img-responsive"/>
                                </td>
                                <td>{{ $details['product']['name'] }}</td>
                                <td class="price">₹{{ $details['product']['net_price'] }}</td>
                                <td>
                                    <input type="number" value="{{ $details['quantity'] }}" onchange="addProduct(this,'{{$id}}','{{$details['product']['net_price']}}')"  class="form-control quantity" min="0" data-price="{{ $details['product']['net_price'] }}"/>
                                </td>
                                <td class="subtotal">₹{{ $details['product']['net_price'] * $details['quantity'] }}</td>
                                <td>
                                    {{-- <form action="/cart/{{$id}}" method="POST" class="remove-cart-form">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{ $id }}"> --}}
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="removeFromCart()">Remove</button>
                                    {{-- </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Your cart is empty</p>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cart Summary</h5>
                    <p class="card-text">Total: ₹<span id="cart-total">{{$gtotal}}</span></p>
                    <a href="purchase/create" class="btn btn-primary">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.querySelectorAll('.quantity').forEach(function(input) {
    input.addEventListener('input', function() {
        const price = parseFloat(input.dataset.price);
        const quantity = parseInt(input.value);
        const subtotalCell = input.closest('tr').querySelector('.subtotal');
        const newSubtotal = price * quantity;

        subtotalCell.textContent = '₹' + newSubtotal.toFixed(2);
        
        updateCartTotal();
    });
});

function updateCartTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(function(subtotalCell) {
        total += parseFloat(subtotalCell.textContent.replace('₹', ''));
    });
    document.getElementById('cart-total').textContent = total.toFixed(2);
}

document.querySelectorAll('.quantity').forEach(function(input) {
    input.addEventListener('input', function() {
        const id = input.closest('tr').dataset.id;
        const quantity = input.value;

        $.ajax({
            url: '/cart/'+id,
            type: 'patch',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                quantity: quantity
            },
            success: function(response) {
                input.closest('tr').querySelector('.subtotal').textContent = '₹' + response.subtotal.toFixed(2);
                document.getElementById('cart-total').textContent = response.total.toFixed(2);
            }
        });
    });
});
function addProduct(qty,productid,price){
    // alert(qty);
    // alert(productid);
    if(Number(qty.value)<1 ){
        if(confirm("Do you really want to remove this product from cart?"))
            document.getElementById('tr_'+productid).remove();
        else{
            qty.value=1;
            // alert(price);
            // input.closest('tr').querySelector('.subtotal').textContent = '₹' + (price*qty.value);

        }
        }
        $.ajax({
         url: '/cart/'+productid,
            type: 'get',
            data:`id=${productid}&quantity=${qty.value}`,
            success: function(response) {  
            }
        });

}
function removeFromCart(productid){
    let confirm = confirm("do you really want to remove this product from cart?")
    if(confirm){
        document.getElementById('tr_'+productid).remove();
    }
}
</script>
@endsection
