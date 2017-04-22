/*
@鍔熻兘锛氳喘鐗╄溅椤甸潰js
@浣滆�咃細diamondwang
@鏃堕棿锛�2013骞�11鏈�14鏃�
*/
//璁＄畻璐墿杞︽�婚噾棰�
function totalPrice()
{
	var total = 0;
	$(".col5 span").each(function(){
		total += parseFloat($(this).text());
	});

	$("#total").text(total.toFixed(2));
}
$(function(){
	
	//鍑忓皯
	$(".reduce_num").click(function(){
		var amount = $(this).parent().find(".amount");
		if (parseInt($(amount).val()) <= 1){
			alert("商品数量最少为1");
		} else{
			$(amount).val(parseInt($(amount).val()) - 1);
		}
		//灏忚
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(amount).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//鎬昏閲戦
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));
	});

	//澧炲姞
	$(".add_num").click(function(){
		var amount = $(this).parent().find(".amount");
		var num = parseInt(amount.val()) + 1;
		var tr = $(this).closest("tr");


		var goods_id = tr.attr('data-goods-id');

		//鍙戣捣ajax璇锋眰锛屽皢瑕佷慨鏀圭殑鍟嗗搧id鍜屾暟閲忓彂閫佸埌鍚庡彴
		$.post('/shop/ajax?filter=modify',{goods_id:goods_id,num:num},function(data){
			if(data=='success'){
				//淇敼鎴愬姛
				$(amount).val(num);
				//灏忚
				var subtotal = parseFloat(tr.find(".col3 span").text()) * parseInt($(amount).val());
				tr.find(".col5 span").text(subtotal.toFixed(2));
				//鎬昏閲戦
				var total = 0;
				$(".col5 span").each(function(){
					total += parseFloat($(this).text());
				});

				$("#total").text(total.toFixed(2));
			}else{
				console.log('修改失败:'+data);
			}
		});
	});

	//鐩存帴杈撳叆
	$(".amount").blur(function(){
		if (parseInt($(this).val()) < 1){
			alert("商品数量最少为1");
			$(this).val(1);
		}
		//灏忚
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(this).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//鎬昏閲戦
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));

	});

	$(".btn_del").click(function(){
		if(confirm('确定删除该商品吗？')){
			var tr = $(this).closest("tr");
			var goods_id = tr.attr('data-goods-id');
			$.post('/shop/ajax?filter=del',{goods_id:goods_id},function(data){
				if(data=="success"){
					tr.remove();
					totalPrice();
				}
			});
		}
	});

});