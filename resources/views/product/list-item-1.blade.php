<div class="col-lg-2">
    <div>
        <img style="width: 100%" alt="" src="{{ $image }}"/>
    </div>
    <div><strong><a href="/product-{{ $id }}">{{ $title }}</a></strong></div>
    <span class="label label-primary">{{ $brand }}</span>
    <h5>{{ $model->weight }} кг.</h5>
    <h3>{{ $model->getPrice() }}</h3>

</div>