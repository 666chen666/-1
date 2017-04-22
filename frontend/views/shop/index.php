<!--  商品分类部分 start-->


    <div class="cat_bd">
        <?php foreach ($goods as $good):?>
            <div class="cat">
                <h3><a href=""><?=$good->name?></a> <b></b></h3>
                <div class="cat_detail">
                <?php foreach($good->cates as $cate){
                    echo '<dl class="dl_1st">
                    <dt><a href="">'.$cate->name.'</a></dt>';
                    foreach($cate->cates as $rows){
                        echo '<dd><a href="/shop/list?id='.$rows->id.'">'.$rows->name.'</a></dd>';
                    }
                    echo '</dl>';
                }?>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
<!--  商品分类部分 end-->