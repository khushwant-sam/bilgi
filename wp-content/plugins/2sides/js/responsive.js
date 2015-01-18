

var $=jQuery;
 function getRowsHexagons()
    {
        var RowsForHexagons=document.getElementById("row_count").value,
        HtmlForHexagonsNumer='',
        DataSelectTag='';
        
        //Creating options for selecting no. of hexagons in particular row
        DataSelectTag  = "<select name='hexagonsinrow[]' class='hexagonsinrow' onchange='createHexagons();'>";
        for(var i=2;i<20;i++)
            DataSelectTag+="<option>"+i+"</option>";
        DataSelectTag+="</select>";
        // creating options ends here

        for(var j=0;j<RowsForHexagons;j++)
            HtmlForHexagonsNumer+="<tr><td> Hexagons in row "+(parseInt(j)+1)+"</td><td>"+DataSelectTag+"</td></tr>";
        document.getElementById("rowContent").innerHTML = HtmlForHexagonsNumer;
        createHexagons();

    }

    getRowsHexagons();
    document.getElementById("row_count").addEventListener('change',function(){
        getRowsHexagons();
    });
    document.getElementById("preview").addEventListener('click',function(){
        getRowsHexagons();
    });

    function TypeSelector () {
        if(document.getElementById("type").value == 1)
            document.getElementById("custom").style.visibility="hidden";
        else
            document.getElementById("custom").style.visibility="inherit";
        createHexagons();
    }
    TypeSelector();
    document.getElementById("type").addEventListener('change',function(){
        TypeSelector();

    });
    
    var totalHexagonsinRow=0;
    function createHexagons()
    {
        var HexHtmlData = '<div id="hexagons_container" style=" width: 100%;">',
        rowLimit = document.getElementById("row_count").value;
        var checkHigestRowHexagonCount=document.getElementsByClassName("hexagonsinrow");
        var higestValue=0;
        for(var ij=0;ij<checkHigestRowHexagonCount.length;ij++)
        {
            if(checkHigestRowHexagonCount[ij]>higestValue)
                higestValue=checkHigestRowHexagonCount[ij];
        }
        totalHexagonsinRow=higestValue;
        for(var i=1;i<=rowLimit;i++)
        {
            HexHtmlData +='<div class="hex2-row">';
            var HexagonLimit=document.getElementsByClassName("hexagonsinrow")[i-1].value;
            for(var j=1;j<=HexagonLimit;j++)
            {
                if(j%2==0)
                {
                    HexHtmlData +='<div class="hex2 even">'+
                        '<div class="left"></div>'+
                        '<div class="middle"></div>'+
                        '<div class="right"></div>'+
                    '</div>';
                }
                else
                {
                    HexHtmlData +='<div class="hex2">'+
                        '<div class="left"></div>'+
                        '<div class="middle"></div>'+
                        '<div class="right"></div>'+
                    '</div>';
                }


            }
            HexHtmlData +='<br style="clear:both;"></div>';
        }
        HexHtmlData +='<br style="clear:both;"></div>';
        //console.log(HexHtmlData);
        document.getElementById("demo_hexagons").innerHTML = HexHtmlData;
        var SpacingFinal = document.getElementById("hpadding").value ;
        var HexagonSize = document.getElementById("width").value ;
        
        if(document.getElementById("type").value == 0)
            var size_hex = "ture" ;
        else
            var size_hex = "false";
        var color=document.getElementById("bcolor").value;
        setTimeout(function(){ 
            totalHexagonsinRow=10;

            if(document.getElementById("type").value == 0)
            {
                find_params (SpacingFinal,HexagonSize,color);
                console.log("alert"+color);
            }   
            else
                find_params (SpacingFinal,color);
        } ,1 );
    }



$( window ).resize(function() {
		//find_params (10);
	});
var HexagonWidthGlobal=10;
var totalHexagonsinRow=10;
	 function find_params (padding,size,color) {
		var containerWidth = $("#hexagons_container").width(),
		divider=0,
		spacing=padding;
		for(var i=1;i<totalHexagonsinRow+1;i++)
		{
			if(i%2==0)
				divider+=parseInt(1);
			else
				divider+=parseInt(2);
		}
        var HexagonWidth = ((containerWidth-((totalHexagonsinRow-1)*spacing))/divider);
		//console.log(containerWidth+"~"+totalHexagonsinRow+"~"+spacing+"~"+divider);
		var HexagonalHeight = ((104/120)*HexagonWidth)*2;
        if(size)
        {
            HexagonWidth = size;
            HexagonalHeight = (64.248/37.066)*HexagonWidth;
            console.log("custom");
        }   
        //alert(color);
		var BorBottom = (HexagonalHeight/2)+"px solid transparent",
		BorLeft=BorRight = (HexagonWidth/2)+"px solid #"+color,
		BorLeft_Inner=BorRight_Inner = (HexagonWidth/2)+"px solid #"+color,
		BorTop = (HexagonalHeight/2)+"px solid transparent",
		HexagonalMarTop = HexagonalHeight/2+parseInt(1) + "px",
		HexagonalMarRight = "-"+parseInt(parseInt(((HexagonWidth-spacing) /2))-parseInt(1)) + "px",
		HexagonalMarBottom = "-"+((HexagonalHeight-spacing) /2) + "px";

		//console.log(HexagonalHeight+"~"+ HexagonalMarTop);
		$(".hex2 .middle").width(HexagonWidth);
		HexagonWidthGlobal=HexagonWidth;
		$(".hex2 .middle").height(HexagonalHeight);
		$(".hex2 .middle").css({"background":"#"+color});
		$(".hex2 .right").css({"border-left":BorLeft,"border-top":BorTop,"border-bottom":BorBottom});
		$(".hex2 .left").css({"border-right":BorRight,"border-top":BorTop,"border-bottom":BorBottom});
		$(".hex2_inside .right").css({"border-left":BorLeft_Inner,"border-top":BorTop,"border-bottom":BorBottom});
		$(".hex2_inside .left").css({"border-right":BorRight_Inner,"border-top":BorTop,"border-bottom":BorBottom});
		
		$(".hex2.even").css("margin-top",HexagonalMarTop);
		$(".hex2").css({"margin-right":HexagonalMarRight,"margin-bottom":HexagonalMarBottom});
		$(".hex2.even").css({"margin-right":HexagonalMarRight,"margin-bottom":HexagonalMarBottom});
	}
	find_params();


$(".hex2").hover(function(){
	$(this).children(0).find(".middle").animate({width:3*HexagonWidthGlobal+"px"},300);
},function(){
	$(this).children(0).find(".middle").animate({width:HexagonWidthGlobal},200);
});


