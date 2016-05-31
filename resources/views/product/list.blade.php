
<div class="row">
@foreach(\App\Models\ProductModel::getActiveProducts() as $product)
    @include('product.list-item-1', $product->toArray() + ['model' => $product])
@endforeach
</div>

@include('product.modal.buy-one-click')