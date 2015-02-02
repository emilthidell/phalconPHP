var getvalue = 4
jQuery.fn.RainSnow = function(e) {
    var t = {
        effect_name: "rain",
        drop_appear_speed: 100,
        drop_falling_speed: 7e3,
        wind_direction: 3,
        drop_rotate_angle: "-10deg",
        drop_count_width_height: [
            [2, 10],
            [2, 15],
            [2, 20]
        ],
        lighting_effect: [true, 50],
        drop_left_to_right: false,
        balloon_effect: true
    };
    var n = $.extend({}, t, e);
    return this.each(function() {
        if (getvalue > 0) {
            var t = $(this);
            var n = e["effect_name"];
            var r = e["drop_appear_speed"];
            var s = e["drop_falling_speed"];
            var o = e["wind_direction"];
            var u = e["drop_rotate_angle"];
            var a = e["drop_count_width_height"];
            var f = a.length;
            var l = e["lighting_effect"];
            var c = e["drop_left_to_right"];
            var h = e["balloon_effect"];
            var p = 1;
            t.addClass(n);
            var d = 0;
            var v = parseInt($(window).height())+parseInt(100);
            var m = new Array
        }
        for (i in a) {
            m[i] = i
        }
        var g = 0;
        $(document).scroll(function(e) {
            g = $(window).scrollTop()
        });
        var y = setInterval(function() {
            d = d + 1;
            var e = -200;
            var r = Math.floor(Math.random() * 100 + 1);
            var i = r + o;
            if (n == "balloon" || n == "snow") {
                if (c == true) {
                    r = -10
                }
            }
            if (n == "rain" && getvalue > 0) {
                if (l[0] == true) {
                    if (d % l[1] == 0) {
                        p++;
                        if (p % 2 == 0) {
                            var f = "<span class='lighting_effect'></span>"
                        } else {
                            var f = "<span class='lighting_effect right'></span>"
                        }
                        t.append(f);
                        $(".lighting_effect").animate({
                            opacity: 1
                        }, 100, function() {
                            $(".lighting_effect").animate({
                                opacity: 0
                            }, 100, function() {
                                $(".lighting_effect").animate({
                                    opacity: 1
                                }, 100, function() {
                                    $(".lighting_effect").remove()
                                })
                            })
                        })
                    }
                }
            }
            var y = Math.floor(Math.random() * m.length);
            if (n == "balloon" && h == true && getvalue > 0) {
                var b = '<span class="drop drop' + y + " incriment" + d + '" style="bottom:0px; left:' + r + "%; width:" + a[y][0] + "px; height:" + a[y][1] + "px; transform: rotate(" + u + "); -ms-transform:rotate(" + u + "); -moz-transform: rotate(" + u + "); -webkit-transform: rotate(" + u + ');"></span>';
                t.append(b);
                var w = $(".incriment" + d + "").outerHeight();
                $(".incriment" + d + "").animate({
                    bottom: v - w + g,
                    left: i + "%"
                }, s, function() {
                    $(this).remove()
                })
            } else {
                var b = '<span class="drop drop' + y + " incriment" + d + '" style="top:' + e + "px; left:" + r + "%; width:" + a[y][0] + "px; height:" + a[y][1] + "px; transform: rotate(" + u + "); -ms-transform:rotate(" + u + "); -moz-transform: rotate(" + u + "); -webkit-transform: rotate(" + u + ');"></span>';
                t.append(b);
                var w = $(".incriment" + d + "").outerHeight();
                $(".incriment" + d + "").animate({
                    top: v - w + g,
                    left: i + "%"
                }, s, function() {
                    $(this).remove()
                })
            }
        }, r)
    })
}
