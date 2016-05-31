<div class="col-lg-2 product-item-box" id="product-item-{{ $id }}">
    <div class="white-wrapper">
        <div>
            <img style="width: 100%" alt="" src="{{ $model->getImage() }}"/>
        </div>
        <div><strong><a href="/product-{{ $id }}">{{ $title }}</a></strong></div>
        <span class="label label-primary">{{ $brand }}</span>

        <table style="width: 100%;">
            <tr>
                <td><input type="checkbox" checked></td>
                <td style="text-align: right;">{{ $weight }} кг.</td>
                <td style="text-align: center;"><input data-product-id="{{ $id }}" class="product-counter form-control input-sm mini-item-input-text" type="text" value="1"></td>
                <td style="text-align: right;"><h4>{{ $model->getPrice() }}</h4></td>
            </tr>
        @foreach($model->getGroupProducts() as $group_product)
            <tr>
                <td><input type="checkbox"></td>
                <td style="text-align: right;">{{ $group_product->weight }} кг.</td>
                <td style="text-align: center;"><input data-product-id="{{ $group_product->id }}" class="product-counter form-control input-sm mini-item-input-text" type="text" value="1"></td>
                <td style="text-align: right;"><h4>{{ $group_product->getPrice() }}</h4></td>
            </tr>
        @endforeach
        </table>

        <a type="button" class="btn btn-link btn-sm"><span class="glyphicon glyphicon-star"></span> В избранное</a>

        <div style="width: 100%" class="btn-group-vertical btn-group-sm" role="group">
            <button type="button" class="btn btn-default" onclick="buyOneClick({{ $id }});">Купить в один клик</button>
            <button type="button" class="btn btn-default" onclick="addToCard({{ $id }});">Положить в корзину</button>
        </div>
        <p style="margin: 10px 0 0; font-weight: bold" class="small">Конкуренты:</p>
        <table style="width: 100%">
        @foreach($model->rivals_links()->get() as $rival_link)
            <tr class="small">
                <td><a target="_blank" href="{{ $rival_link->url }}">{{ parse_url($rival_link->url)['host'] }}</a></td>
                <td style="text-align: right">{{ $rival_link->getPrice() }}</td>
            </tr>
        @endforeach
        </table>
    </div>
</div>