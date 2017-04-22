<!--  商品分类部分 start-->


<div class="cat_bd none">
    <?php foreach ($goods as $good):?>
        <div class="cat">
            <h3><a href=""><?=$good->name?></a> <b></b></h3>
            <div class="cat_detail none">
                <?php foreach($good->cates as $cate){
                    echo '<dl class="dl_1st">
                    <dt><a href="">'.$cate->name.'</a></dt>';
                    foreach($cate->cates as $rows){
                        echo '<dd><a href="">'.$rows->name.'</a></dd>';
                    }
                    echo '</dl>';
                }?>
            </div>
        </div>
    <?php endforeach;?>
<!--  商品分类部分 end-->