$(function(){
    $('.to_top').css({display: 'none'});

    var i = 0;
    var section_top = [];
    var fadeSpeed = 500;
    var _scrollEvent;
    var _scrollEvent2;
    var ballid = 0;
    $(".slideball .ball").eq(0).css({"background-color" : "red"});
    while (i< 4){
        section_top[i] = $(".fill_section").eq(i).offset().top;
        $(".fill_section").eq(i).css({opacity: '0'});
        i++;
    }
    var center_section = (section_top[1] - section_top[0]) / 2 ;
    $(".fill_section").eq(0).animate({opacity: '1'}, fadeSpeed);
    $('html, body').animate({scrollTop: 0},0,'swing');
    // トップに戻る
    $(document).on('click','.to_top',function(){
        $('html, body').animate({scrollTop: 0},fadeSpeed,'swing');
    });
    // スクロール時の各種コマンド
    $(window).scroll(function () {

        if(!_scrollEvent){
            _scrollEvent = setTimeout(function(){
                _scrollEvent = null;
                if($(window).scrollTop() >= 100) {
                    $('.to_top').stop().animate( { opacity: 'show',}, { duration: fadeSpeed, easing: 'swing' } );
                } else {
                    $('.to_top').stop().animate( { opacity: 'hide',}, { duration: fadeSpeed, easing: 'swing' } );
                }
                var i = 0;
                if ($(".fill_section").eq(3).css('opacity') == '0'){
                    while(i< 4){
                        if($(window).scrollTop() >= section_top[i] - 500 ){
                            $(".fill_section").eq(i).animate({opacity: '1'}, fadeSpeed);
                        }
                        i++;
                    }
                }
            }, 200);
        }
        if(!_scrollEvent2){
            _scrollEvent2 = setTimeout(function(){
                _scrollEvent2 = null;
                switch (true) {
                    case $(window).scrollTop() < center_section:
                        $('html, body').animate({scrollTop: 0},fadeSpeed,'swing');
                        break;
                    case $(window).scrollTop() < center_section * 3:
                        pageto(1);
                        break;
                    case $(window).scrollTop() < center_section * 5:
                        pageto(2);
                        break;
                    default:
                        pageto(3);
                }
            },3000);
        }
    });
    function pageto(n) {
        $('html, body').stop().animate({scrollTop:section_top[n]},fadeSpeed,'swing');
    }
    // 次のセレクションへ移動
    $(document).on('click','.nextsection',function(){
        var index = $(".nextsection").index(this) + 1 ;
        $('html, body').stop().animate({scrollTop:section_top[index]},fadeSpeed,'swing')
    });

    //スライダー
    //1.スライドの長さを測る
    var slideWidth = $('.slide').outerWidth();
    var slideNum = $('.slide').length;
    var slideSetWidth = slideWidth * slideNum;
    var slideid = 0;
    var lastslide = 0;
    //2.並べる
    $('.slideSet').css('width', slideSetWidth);
    var click_flg = true;


    // 前へボタンが押されたとき
    $('.slideleft').click(function(){
        if(click_flg){
            buttonaction(slideleft(1),500);
        }else {
            return false;
        }
    });
    // 次へボタンが押されたとき
    $('.slideright').click(function(){
        if(click_flg){
            buttonaction(slideright(1),500);
        }else {
            return false;
        }
    });
    // 各ボタンストッパー
    function buttonaction(actionFuction,time){
        click_flg = false;
        //実行内容
        actionFuction
        setTimeout(function(){
            click_flg = true;
        },time)
    }
    // ボールジャンプ
    $(document).on('click','.ball',function(){
        if(click_flg){
            var nextslide = $(".ball").index(this);
            if (lastslide < nextslide){
                i = nextslide - lastslide;
                buttonaction(slideright(i),500);
            }else if(lastslide > nextslide) {
                i = lastslide - nextslide;
                buttonaction(slideleft(i),500);
            }
        }else {
            return false;
        }
    })
    //色を変更するボールを選択
    function ballselect(){
        switch ($('.slideSet .slide:first').attr('id')) {
            case 'page1':
                nextslide = 0;
                break;
            case 'page2':
                nextslide = 1;
                break;
            case 'page3':
                nextslide = 2;
                break;
            case 'page4':
                nextslide = 3;
                break;
            case 'page5':
                nextslide = 4;
        }
        ballcolor();
    }
    //ボール色変更
    function ballcolor(){
        $.when(
            $(".slideball .ball").css({"background-color" : "aqua"})
        ).done(function(){
            $(".slideball .ball").eq(nextslide).css({"background-color" : "red"});
            lastslide = nextslide;
        });
    }
    //右スライド送り
    function slideright(count){
        clearTimeout(timer)
            //li先頭要素のクローンを作成
        for (var i = 0; count > i; i++){
            $(".slide").eq(i).clone(true).insertAfter($(".slide:last"));
        }
            var slidewidth = (-800 * count)+ 'px';
        $.when(
            $(".slide:first").animate({
                marginLeft : slidewidth
            },500)
        ).done(function(){
            for (var i = 0; count > i; i++){
                $(".slide:first").remove();
            }
            ballselect();
            autoslide();
        });

    }
    //左スライド送り
    function slideleft(count){
        clearTimeout(timer)
        var slidewidth = (800 * count)+ 'px';
        for (var i = 0; count > i; i++){
            $.when(
                $(".slide:last").clone(true).insertBefore($(".slide:first"))
            ).done(function(){
                $(".slide:last").remove();
            });
        }
        $.when(
            $(".slideSet .slide:first").animate({
                marginLeft : "-" + slidewidth
            },0)
        ).done(function(){
            $(".slideSet .slide:first").animate({
                marginLeft : "0"
            },500,function(){
                ballselect();
                autoslide();
            });
        })
    }
    //自動スライド送り
    function autoslide() {
        timer = setTimeout(function(){
            buttonaction(slideright(1),500);
            }, 5000);
    }
    autoslide();

    //バナー
    var bannerFlug = true;
    if($('.banner').length < 4){
        $('.bannerleft').stop().animate( { opacity: 'hide',}, { duration: fadeSpeed, easing: 'swing' } );
        $('.bannerright').stop().animate( { opacity: 'hide',}, { duration: fadeSpeed, easing: 'swing' } );
    }

    // 前へボタンが押されたとき
    $('.bannerleft').click(function(){
        if(click_flg){
            buttonaction(toleftbanner(),500);
        }else {
            return false;
        }
    });
    // 次へボタンが押されたとき
    $('.bannerright').click(function(){
        if(click_flg){
            buttonaction(torightbanner(),500);
        }else {
            return false;
        }
    });
    // リサイズ
    $( window ).resize(function(){
        if(!_scrollEvent){
            _scrollEvent = setTimeout(function(){
                _scrollEvent = null;
                if($(".banners").width() <= 790){
                    bannerFlug = false;
                    $(".banner").eq(1).animate({
                        margin : "0 300px 0 5px"
                    },500)
                }else{
                    bannerFlug = true;
                    $(".banner").eq(1).animate({
                        margin : "0 5px 0 5px"
                    },500)
                }
            }, 500);
        }
    });

    //右バナー送り
    function torightbanner(){
            //li先頭要素のクローンを作成
        for (var i = 0; 3 > i; i++){
            $(".banner").eq(i).clone(true).insertAfter($(".banner:last"));
        }
            var slidewidth = (-295 * 3)+ 'px';
        $.when(
            $(".banner:first").animate({
                marginLeft : slidewidth
            },500)
            
        ).done(function(){
            for (var i = 0; 3 > i; i++){
                $(".banner:first").remove();
            }
        });
    }
    //左スライド送り
    function toleftbanner(){
        var slidewidth = (295 * 3)+ 'px';
        var banners = $('.banner').length - 1;
        for (var i = 1; 4 > i; i++){
            $(".banner").eq(banners).clone(true).insertBefore($(".banner:first"))
        }

            $(".banner:first").animate({
                marginLeft : "-" + slidewidth
            },0)

            $(".banner:first").animate({
                marginLeft : "10"
            },500,function(){
                for (var i = 0; 3 > i; i++){
                    $(".banner:last").remove();
                }
            })

    }

});