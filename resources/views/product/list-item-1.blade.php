<div class="col-lg-2 product-item-box">
    <div class="white-wrapper">
        <div>
            <img style="width: 100%" alt="" src="{{ $model->getImage() }}"/>
        </div>
        <div><strong><a href="/product-{{ $id }}">{{ $title }}</a></strong></div>
        <span class="label label-primary">{{ $brand }}</span>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: right;">{{ $weight }} кг.</td>
                <td style="text-align: right;"><h4>{{ $model->getPrice() }}</h4></td>
            </tr>
        @foreach($model->getGroupProducts() as $group_product)
            <tr>
                <td style="text-align: right;">{{ $group_product->weight }} кг.</td>
                <td style="text-align: right;"><h4>{{ $group_product->getPrice() }}</h4></td>
            </tr>
        @endforeach
        </table>
        @foreach($model->rivals_links()->get() as $rival_link)
            <a class="label label-danger" target="_blank" href="{{ $rival_link->url }}">{{ $rival_link->getPrice() }}</a>
        @endforeach
    </div>
</div>